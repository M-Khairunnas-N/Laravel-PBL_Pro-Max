<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\StoreAdminKaderRequest;
use App\Http\Requests\Admin\User\StoreUserRequest;
use App\Http\Requests\Admin\User\UpdateUserRequest;
use App\Http\Requests\Shared\OptimisticLockingRequest;
use App\Models\Admin;
use App\Models\Kader;
use App\Models\Penduduk;
use App\Models\User;
use App\Services\FilterServices;
use App\Services\ImageLogic;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserResource extends Controller
{
    public function __construct(
        private readonly FilterServices $filter
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $breadcrumb = (object) [
            'title' => 'Data User'
        ];

        $activeMenu = 'user';

        /**
         * Filter user data base filter feature
         */
        $users = $this->filter->getFilteredUser($request)->paginate(5);
        $users->appends(request()->all());

        /**
         * delete data that trashed in a subMonth in soft deleted kader
         */
        if (Kader::onlyTrashed()->where('deleted_at', '<=', now()->subMonth())->exists()) {
            Artisan::call('model:prune');
        }

        return view('admin.user.index', compact('breadcrumb', 'activeMenu', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View|RedirectResponse
    {
        $breadcrumb = (object) [
            'title' => 'Data User'
        ];

        $activeMenu = 'user';

        /**
         * retrieve valid penduduk data for create new account
         */
        $penduduks = Penduduk::whereDoesntHave('kaders')
            ->whereDoesntHave('admins')
            ->whereRaw('TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) >= 20')
            ->whereRaw('TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) <= 50')
            ->get();

        /**
         * return error message if penduduk data aren't availble
         */
        if ($penduduks->count() === 0) {
            return redirect()->intended('admin/user' . session('urlPagination'))
                ->with('error', 'Data penduduk(usia 20-50 tahun dan tidak punya akun) tidak tersedia untuk penambahan user');
        }

        return view('admin.user.tambah', compact('breadcrumb', 'activeMenu', 'penduduks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $userRequest, StoreAdminKaderRequest $adminKaderRequest): RedirectResponse
    {
        $user = User::create($userRequest->input());
        $adminKaderRequest->merge([
            'user_id' => $user->user_id
        ]);

        /**
         * check if level admin, kader or ketua
         */
        if ($user->level === 'admin') {
            Admin::create($adminKaderRequest->all());
        }
        /**
         * if level kader, check and restore if data is soft deleted before
         */
        else {
            $softDeletedKader = Kader::withTrashed()->where('penduduk_id', $adminKaderRequest->input('penduduk_id'))->first();
            if ($softDeletedKader) {
                $softDeletedKader->restore();
                $softDeletedKader->update($adminKaderRequest->all());
            } else {
                Kader::create($adminKaderRequest->all());
            }
        }

        return redirect()->intended('admin/user' . session('urlPagination'))
            ->with('success', 'Data user berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View|RedirectResponse
    {
        $breadcrumb = (object) [
            'title' => 'Data User'
        ];

        $activeMenu = 'user';

        /**
         * check if data available or deleted in same time
         */
        $user = User::with(['kaders', 'admins'])->find($id);
        if ($user === null) {
            return redirect()->intended('admin/user' . session('urlPagination'))->with('error', 'Data user baru saja dihapus admin lain');
        }

        /**
         * retrieve admin or kader nama in penduduks table
         */
        $penduduk = User::with(['admins', 'kaders'])->findOrFail($id);
        if ($penduduk->kaders->isNotEmpty()) {
            $penduduk = $penduduk->kaders->first()->penduduk;
        }else if ($penduduk->admins->isNotEmpty()) {
            $penduduk = $penduduk->admins->first()->penduduk;
        }

        return view('admin.user.detail', compact('breadcrumb', 'activeMenu', 'user', 'penduduk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View|RedirectResponse
    {
        $breadcrumb = (object) [
            'title' => 'Data User'
        ];

        $activeMenu = 'user';

        /**
         * check if data available or deleted in same time
         */
        $user = User::find($id);
        if ($user === null) {
            return redirect()->intended('admin/user' . session('urlPagination'))->with('error', 'Data user baru saja dihapus admin lain');
        }

        /**
         * retrieve admin or kader nama in penduduks table
         */
        $pendudukNama = User::with(['admins', 'kaders'])->findOrFail($id);
        if ($pendudukNama->kaders->isNotEmpty()) {
            $pendudukNama = $pendudukNama->kaders->first()->penduduk->nama;
        }else if ($pendudukNama->admins->isNotEmpty()) {
            $pendudukNama = $pendudukNama->admins->first()->penduduk->nama;
        }

        return view('admin.user.edit', compact('breadcrumb', 'activeMenu', 'user', 'pendudukNama'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, OptimisticLockingRequest $lockingRequest, string $id): RedirectResponse
    {
        /**
         * try database transaction, because we use sql type
         * database(mysql), to prevent database race condition when
         * update data, we use transaction to rollback if there are any
         * error and catch that error mesasge to display in view
         */
        try {
            /**
             * return $isUpdated for checking update data not just
             * submit when not actually changes
             */
            $isUpdated =  DB::transaction(function () use ($request, $lockingRequest, $id) {
                /**
                 * fill $isUpdated to use in checking update
                 * action
                 */
                $isUpdated = false;
                /**
                 * lock and update with queue users table
                 * to prevent database race condition
                 */
                $user = User::lockForUpdate()->find($id);
                /**
                 * if update action lose race with delete action, return error message
                 */
                if ($user === null) {
                    return redirect()->intended('admin/user' . session('urlPagination'))->with('error', 'Data user sudah dihapus lebih dulu oleh admin lain');
                }
                /**
                 * implement optimistic locking, to prevent other admin update in same time
                 */
                if ($user->updated_at > $lockingRequest->input('updated_at')) {
                    return redirect()->intended('admin/user' . session('urlPagination'))->with('error', 'Data user masih diubah oleh admin lain, coba refresh dan lakukan ubah lagi');
                }
                /**
                 * check if user has change column in users table
                 */
                if ($request->all() !== []) {
                    /**
                     * check if user change level, because we had own logic for level
                     */
                    if ($request->has('level')) {
                        /**
                         * retrieve old level
                         */
                        $level = $user->level;
                        /**
                         * retrieve kader model for updating data
                         */
                        $kader = Kader::where('user_id', $id)->first();
                        /**
                         * if level change from kader or ketua to admin
                         */
                        if ($request->level === 'admin') {
                            Admin::create([
                                'penduduk_id' => $kader->penduduk_id,
                                'user_id' => $id
                            ]);

                            $kader->delete();
                        }
                        /**
                         * if level change from admin to ketua or kader
                         */
                        elseif ($level === 'admin') {
                            $admin = Admin::where('user_id', $id)->first();
                            $this->updateTrashedKader($admin, $id);
                        }
                        /**
                         * if level change from kader to ketua or vice versa
                         */
                        else {
                            $this->updateTrashedKader($kader, $id);
                        }
                    }
                    /**
                     * check if user updated foto_profil
                     */
                    if ($request->has('foto_profil')) {
                        /**
                         * retrieve old hashName foto_profil
                         */
                        $foto_profil = $user->foto_profil;
                        /**
                         * delete foto_profil that saved in public/user directory
                         */
                        ImageLogic::delete($foto_profil, 6, 'user_img');
                        /**
                         * save updated foto_profil in public/user directory
                         *
                         * and change uploaded file value to string hashName in foto_profil
                         */
                        $request->merge([
                            'foto_profil' => ImageLogic::upload($request->input('foto_profil'), 'user_img')
                        ]);
                    }

                    $isUpdated = $user->update($request->input());
                }

                return $isUpdated;
            });

            /**
             * if inside transaction had any redirect return
             */
            if (!is_bool($isUpdated)){
                return $isUpdated;
            }

            return redirect()->intended('admin/user' . session('urlPagination'))
                ->with('success', $isUpdated ? 'Data user berhasil diubah' : 'Namun Data user tidak diubah');
        } catch (\Throwable $e) {
            return redirect()->intended('admin/user' . session('urlPagination'))
                ->with('error', 'Terjadi Masalah Ketika mengubah Data user: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Request $request): RedirectResponse
    {
        /**
         * try database transaction, because we use sql type
         * database(mysql), to prevent database race condition when
         * delete data, we use transaction to rollback if there are any
         * error and catch that error mesasge to display in view
         */
        $request->merge(['updated_at' => Carbon::make($request->input('updated_at'), 'Asia/Jakarta')->timezone('Asia/Jakarta')->format('Y-m-d H:i:s')]);

        try {
            return DB::transaction(function () use ($id, $request) {
                /**
                 * lock and delete with queue users table
                 * to prevent database race condition
                 */
                $user = User::lockForUpdate()->find($id);
                /**
                 * if delete action lose race with delete action or data isn't available, return error message
                 */
                if ($user === null) {
                    return redirect()->intended('admin/user' . session('urlPagination'))->with('error', 'Data user sudah dihapus lebih dulu oleh admin lain');
                }
                /**
                 * check if other user is update our data when we do delete action
                 */
                if ($user->updated_at > $request->input('updated_at')) {
                    return redirect()->intended('admin/user' . session('urlPagination'))->with('error', 'Data user masih diubah oleh admin lain, coba refresh dan lakukan hapus lagi');
                }
                /**
                 * because admin not and kader is soft delete in model and migration,
                 * we do this to softly delete that data
                 */
                Kader::where('user_id', $id)->delete();
                /**
                 * retrieve old hashName foto_profil
                 */
                $foto_profil = $user->foto_profil;
                /**
                 * delete user that also delete admins data because cascadeOnDelete
                 */
                $user->delete();
                /**
                 * delete foto_profil that saved in public/user directory
                 */
                ImageLogic::delete($foto_profil, 6, 'user_img');

                return redirect()->intended('admin/user' . session('urlPagination'))->with('success', 'Data user berhasil dihapus');
            });

        } catch (QueryException) {
            return redirect()->intended('admin/user' . session('urlPagination'))->with('error', 'Data user gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        } catch (\Throwable) {
            return redirect()->intended('admin/user' . session('urlPagination'))->with('error', 'Terjadi Masalah Ketika menghapus Data user');
        }
    }

    /**
     * update data trashed in kader table and delete old model
     *
     * @param Admin|Kader $model
     * @param string $user_id
     * @return void
     */
    private function updateTrashedKader(Admin|Kader $model, string $user_id): void
    {
        $softDeletedKader = Kader::onlyTrashed()->where('penduduk_id', $model->penduduk_id)->first();
        if ($softDeletedKader) {
            $softDeletedKader->restore();
            $softDeletedKader->update([
                'user_id' => $user_id
            ]);
        } else {
            Kader::create([
                'penduduk_id' => $model->penduduk_id,
                'user_id' => $user_id
            ]);
        }

        $model->delete();
    }
}