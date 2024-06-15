<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Penduduk\StorePendudukRequest;
use App\Http\Requests\Admin\Penduduk\UpdatePendudukRequest;
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
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PendudukResource extends Controller
{
    public function __construct(
        private readonly FilterServices $filter)
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $breadcrumb = (object) [
            'title' => 'Data Penduduk'
        ];

        $activeMenu = 'penduduk';

        /**
         * Filter penduduk data base filter feature
         */
        $penduduks = $this->filter->getFilteredData($request)->paginate(10);
        $penduduks->appends(request()->all());

        return view('admin.penduduk.index', compact('breadcrumb', 'activeMenu', 'penduduks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $breadcrumb = (object) [
            'title' => 'Data Penduduk'
        ];

        $activeMenu = 'penduduk';

        $penduduk = Penduduk::where('hubungan_keluarga', 'Kepala Keluarga')->get();

        return view('admin.penduduk.tambah', compact('breadcrumb', 'activeMenu', 'penduduk'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePendudukRequest $request): RedirectResponse
    {
        Penduduk::create($request->all());
        return redirect()->intended('admin/penduduk' . session('urlPagination'))
            ->with('success', 'Data penduduk berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View|RedirectResponse
    {
        $breadcrumb = (object) [
            'title' => 'Data Penduduk'
        ];

        $activeMenu = 'penduduk';

        /**
         * check if data available or deleted in same time
         */
        $penduduk = Penduduk::find($id);
        if ($penduduk === null) {
            return redirect()->intended('admin/penduduk' . session('urlPagination'))->with('error', 'Data penduduk baru saja dihapus admin lain');
        }

        return view('admin.penduduk.detail', compact('breadcrumb', 'activeMenu', 'penduduk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View|RedirectResponse
    {
        $breadcrumb = (object) [
            'title' => 'Data Penduduk'
        ];

        $activeMenu = 'penduduk';

        /**
         * check if data available or deleted in same time
         */
        $penduduk = Penduduk::find($id);
        if ($penduduk === null) {
            return redirect()->intended('admin/penduduk' . session('urlPagination'))->with('error', 'Data penduduk baru saja dihapus admin lain');
        }

        return view('admin.penduduk.edit', compact('breadcrumb', 'activeMenu', 'penduduk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePendudukRequest $request, OptimisticLockingRequest $lockingRequest, string $id): RedirectResponse
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
                 * lock and update with queue penduduks table
                 * to prevent database race condition
                 */
                $penduduk = Penduduk::lockForUpdate()->find($id);
                /**
                 * if update action lose race with delete action, return error message
                 */
                if ($penduduk === null) {
                    return redirect()->intended('admin/penduduk' . session('urlPagination'))->with('error', 'Data penduduk sudah dihapus lebih dulu oleh admin');
                }
                /**
                 * implement optimistic locking, to prevent other kader update artikel in same time
                 */
                if ($penduduk->updated_at > $lockingRequest->input('updated_at')) {
                    return redirect()->intended('admin/penduduk' . session('urlPagination'))->with('error', 'Data penduduk masih diubah oleh admin lain, coba refresh dan lakukan ubah lagi');
                }
                /**
                 * check if user has change column in artikels table
                 */
                if ($request->all() !== []) {
                    $isUpdated = $penduduk->update($request->all());
                }

                return $isUpdated;
            });

            /**
             * if inside transaction had any redirect return
             */
            if (!is_bool($isUpdated)){
                return $isUpdated;
            }

            return redirect()->intended('admin/penduduk' . session('urlPagination'))
                ->with('success', $isUpdated ? 'Data penduduk berhasil diubah' : 'Namun Data penduduk tidak diubah');
        } catch (\Throwable) {
            return redirect()->intended('admin/penduduk' . session('urlPagination'))
                ->with('error', 'Terjadi Masalah Ketika mengubah Data penduduk');
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
                 * lock and delete with queue penduduks table
                 * to prevent database race condition
                 */
                $penduduk = Penduduk::lockForUpdate()->find($id);
                if ($penduduk === null) {
                    return redirect()->intended('admin/penduduk' . session('urlPagination'))->with('error', 'Data penduduk sudah dihapus lebih dulu oleh admin lain');
                }
                /**
                 * check if other user is update our data when we do delete action
                 */
                if ($penduduk->updated_at > $request->input('updated_at')) {
                    return redirect()->intended('admin/penduduk' . session('urlPagination'))->with('error', 'Data penduduk masih diubah oleh admin lain, coba refresh dan lakukan hapus lagi');
                }
                /**
                 * if penduduk has an account either had role kader, ketua, or admin, we retrieve to delete below
                 */
                $kader = Kader::where('penduduk_id', $id)->get('user_id');
                $admin = Admin::where('penduduk_id', $id)->get('user_id');
                /**
                 * we delete penduduk after we search query above in table kaders and admins
                 * this because if there is any error when delete process in database
                 * we can roll back this error
                 *
                 * because when penduduks table deleted, admins and kaders are deleted too in cascadeOnDelete function
                 */
                $penduduk->delete();
                /**
                 * if penduduk is kader
                 */
                if ($kader->containsOneItem()) {
                    $user = User::find($kader[0]->user_id);
                    /**
                     * save foto_profil to delete in public/user directory
                     */
                    $foto_profil = $user->foto_profil;
                    /**
                     * delete user data in database and delete foto_profil image if user had
                     */
                    $user->delete();
                    ImageLogic::delete($foto_profil, 6, 'user_img');
                }
                /**
                 * if penduduk is admin
                 */
                if ($admin->containsOneItem()) {
                    $user = User::find($admin[0]->user_id);
                    /**
                     * save foto_profil to delete in public/user directory
                     */
                    $foto_profil = $user->foto_profil;
                    /**
                     * delete user data in database and delete foto_profil image if user had
                     */
                    $user->delete();
                    ImageLogic::delete($foto_profil, 6, 'user_img');
                }

                return redirect()->intended('admin/penduduk' . session('urlPagination'))->with('success', 'Data penduduk berhasil dihapus');
            });
        } catch (QueryException) {
            return redirect()->intended('admin/penduduk' . session('urlPagination'))->with('error', 'Data penduduk gagal dihapus karena masih dipakai untuk data pengurus pemeriksaan');
        } catch (\Throwable) {
            return redirect()->intended('admin/penduduk' . session('urlPagination'))->with('error', 'Terjadi Masalah Ketika menghapus Data penduduk');
        }
    }
}