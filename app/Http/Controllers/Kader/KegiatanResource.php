<?php

namespace App\Http\Controllers\Kader;

use App\Http\Controllers\Controller;
use App\Http\Requests\Kader\Kegiatan\StoreKegiatanRequest;
use App\Http\Requests\Kader\Kegiatan\UpdateKegiatanRequest;
use App\Http\Requests\Shared\OptimisticLockingRequest;
use App\Models\Kegiatan;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KegiatanResource extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $breadcrumb = (object) [
            'title' => 'Kelola Informasi'
        ];

        $activeMenu = 'info';

        /**
         * Retrieve data for filter feature
         */
        $kegiatans = Kegiatan::orderBy('created_at', 'desc')->paginate(10);

        return view('kader.informasi.kegiatan.list', compact('breadcrumb', 'activeMenu', 'kegiatans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $breadcrumb = (object) [
            'title' => 'Kelola Informasi'
        ];

        $activeMenu = 'info';

        return view('kader.informasi.kegiatan.tambahKegiatan', compact('breadcrumb', 'activeMenu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKegiatanRequest $request): RedirectResponse
    {
        Kegiatan::create($request->all());
        return redirect()->intended('kader/informasi/kegiatan' . session('urlPagination'))
            ->with('success', 'Data kegiatan berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View|RedirectResponse
    {
        $breadcrumb = (object) [
            'title' => 'Kelola Informasi'
        ];

        $activeMenu = 'info';

        /**
         * check if data available or deleted in same time
         */
        $kegiatan = Kegiatan::find($id);
        if ($kegiatan === null) {
            return redirect()->intended('kader/informasi/kegiatan' . session('urlPagination'))
                ->with('error', 'Data kegiatan baru saja dihapus oleh kader lain');
        }

        return view('kader.informasi.kegiatan.edit', compact('breadcrumb', 'activeMenu', 'kegiatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKegiatanRequest $request, OptimisticLockingRequest $lockingRequest, string $id): RedirectResponse
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
            $isUpdated = DB::transaction(function () use ($request, $lockingRequest, $id) {
                /**
                 * fill $isUpdated to use in checking update
                 * action
                 */
                $isUpdated = false;
                /**
                 * lock and update with queue kegiatan table
                 * to prevent database race condition
                 */
                $kegiatan = Kegiatan::lockForUpdate()->find($id);
                /**
                 * if update action lose race with delete action or data isn't available, return error message
                 */
                if ($kegiatan === null) {
                    return redirect()->intended('kader/informasi/kegiatan' . session('urlPagination'))->with('error', 'Data kegiatan sudah lebih dulu dihapus oleh kader lain');
                }
                /**
                 * implement optimistic locking, to prevent other kader update kegiatan in same time
                 */
                if ($kegiatan->updated_at > $lockingRequest->input('updated_at')) {
                    return redirect()->intended('kader/informasi/kegiatan' . session('urlPagination'))->with('error', 'Data kegiatan masih di update oleh kader lain, coba refresh dan lakukan update lagi');
                }
                /**
                 * check if user has change column in kegiatan table
                 */
                if ($request->all() !== []) {
                    $isUpdated = $kegiatan->update($request->all());
                }

                return $isUpdated;
            });

            /**
             * if inside transaction had any redirect return
             */
            if (!is_bool($isUpdated)){
                return $isUpdated;
            }

            return redirect()->intended('kader/informasi/kegiatan' . session('urlPagination'))
                    ->with('success', $isUpdated ? 'Data Kegiatan berhasil diubah' : 'Namun Data Kegiatan tidak diubah');
        } catch (\Throwable) {
            return redirect()->intended('kader/informasi/kegiatan' . session('urlPagination'))
                ->with('error', 'Terjadi Masalah Ketika mengubah Data kegiatan');
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
                 * lock and delete with queue kagiatans table
                 * to prevent database race condition
                 */
                $kegiatan = Kegiatan::lockForUpdate()->find($id);
                /**
                 * if delete action lose race with delete action or data isn't available, return error message
                 */
                if ($kegiatan === null) {
                    return redirect()->intended('kader/informasi/kegiatan' . session('urlPagination'))->with('error', 'Data kegiatan sudah lebih dulu dihapus oleh kader lain');
                }
                /**
                 * check if other user is update our data when we do delete action
                 */
                if ($kegiatan->updated_at > $request->input('updated_at')) {
                    return redirect()->intended('kader/informasi/kegiatan' . session('urlPagination'))->with('error', 'Data kegiatan masih di update oleh kader lain, coba refresh dan lakukan hapus lagi');
                }
                /**
                 * delete kegiatan data in database
                 */
                $kegiatan->delete();

                return redirect()->intended('kader/informasi/kegiatan' . session('urlPagination'))->with('success', 'Data kegiatan berhasil dihapus');
            });
        } catch (QueryException) {
            return redirect()->intended('kader/informasi/kegiatan' . session('urlPagination'))->with('error', 'Data kegiatan gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        } catch (\Throwable) {
            return redirect()->intended('kader/informasi/kegiatan' . session('urlPagination'))->with('error', 'Terjadi Masalah Ketika menghapus Data kegiatan');
        }
    }
}
