<?php

namespace App\Http\Controllers\Kader;

use App\Events\Lansia\PemeriksaanLansiaCreated;
use App\Events\Lansia\PemeriksaanLansiaUpdated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Kader\Lansia\StoreLansiaRequest;
use App\Http\Requests\Kader\Lansia\UpdateLansiaRequest;
use App\Http\Requests\Kader\Pemeriksaan\StorePemeriksaanRequest;
use App\Http\Requests\Kader\Pemeriksaan\UpdatePemeriksaanRequest;
use App\Http\Requests\Shared\OptimisticLockingRequest;
use App\Models\Kader;
use App\Models\Pemeriksaan;
use App\Models\PemeriksaanLansia;
use App\Models\Penduduk;
use App\Services\FilterServices;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LansiaResource extends Controller
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
            'title' => 'Pemeriksaan Lansia'
        ];

        $activeMenu = 'lansia';

        /**
         * Filter lansia data base filter feature
         */
        $penduduks = $this->filter->getFilteredDataLansia($request)->paginate(10);
        $penduduks->appends(request()->all());

        return view('kader.lansia.index', compact('breadcrumb', 'activeMenu', 'penduduks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View|RedirectResponse
    {
        $breadcrumb = (object) [
            'title' => 'Pemeriksaan Lansia'
        ];

        $activeMenu = 'lansia';

        /**
         * retrieve all available lansia data from penduduk
         */
        $lansiasData = Penduduk::whereRaw('TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) >= 60')->get(['penduduk_id', 'nama', 'tgl_lahir', 'alamat']);
        /**
         * return error message if penduduk lansia data aren't availble
         */
        if ($lansiasData->count() === 0) {
            return redirect()->intended('kader/lansia' . session('urlPagination'))
                ->with('error', 'Tidak terdapat data penduduk lansia(usia 60 tahun keatas), coba hubungi admin');
        }

        return view('kader.lansia.tambah', compact('breadcrumb', 'activeMenu', 'lansiasData'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLansiaRequest $lansiaRequest, StorePemeriksaanRequest $pemeriksaanRequest): RedirectResponse
    {
        $pemeriksaan = Pemeriksaan::create($pemeriksaanRequest->all());
        $lansiaRequest->merge([
            'pemeriksaan_id' => $pemeriksaan->pemeriksaan_id
        ]);
        $pemeriksaanLansia = PemeriksaanLansia::create($lansiaRequest->all());

        event(new PemeriksaanLansiaCreated($pemeriksaan, $pemeriksaanLansia));

        return redirect()->intended('kader/lansia' . session('urlPagination'))
            ->with('success', 'Data Lansia berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View|RedirectResponse
    {
        $breadcrumb = (object)[
            'title' => 'Pemeriksaan Lansia'
        ];

        $activeMenu = 'lansia';

        /**
         * check if data available or deleted in same time
         */
        $lansiaData = Pemeriksaan::with('pemeriksaan_lansia', 'penduduk')->find($id);
        if ($lansiaData === null) {
            return redirect()->intended('kader/lansia' . session('urlPagination'))->with('error', 'Data lansia baru saja dihapus kader lain');
        }

        /**
         * find all kader data, although it has soft deleted
         */
        $kader = Kader::withTrashed()->find($lansiaData->kader_id)->only('penduduk_id')['penduduk_id'];
        $dataKader = Penduduk::find($kader)->only(['nama', 'NIK']);

        return view('kader.lansia.detail', compact('breadcrumb', 'activeMenu', 'lansiaData', 'dataKader'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View|RedirectResponse
    {
        $breadcrumb = (object)[
            'title' => 'Pemeriksaan Lansia'
        ];

        $activeMenu = 'lansia';

        /**
         * check if data available or deleted in same time
         */
        $lansiaData = Pemeriksaan::with('pemeriksaan_lansia', 'penduduk')->find($id);
        if ($lansiaData === null) {
            return redirect()->intended('kader/lansia' . session('urlPagination'))->with('error', 'Data lansia baru saja dihapus kader lain');
        }

        return view('kader.lansia.edit', compact('breadcrumb', 'activeMenu', 'lansiaData'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLansiaRequest $lansiaRequest, UpdatePemeriksaanRequest $pemeriksaanRequest, OptimisticLockingRequest $lockingRequest, string $id): RedirectResponse
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
            $isUpdated =  DB::transaction(function () use ($lansiaRequest, $pemeriksaanRequest, $lockingRequest, $id) {
                /**
                 * return $isUpdated for checking update data not just
                 * submit when not actually changes
                 */
                $isUpdated = false;
                /**
                 * retrieve original data from update action below for
                 * event
                 */
                $originalPemeriksaan = new Collection();
                $originalLansia = new Collection();

                /**
                 * lock and update with queue pemeriksaan table
                 * to prevent database race condition
                 *
                 * and check if use has change column in pemeriksaans table
                 */
                $pemeriksaan = Pemeriksaan::lockForUpdate()->find($id);
                /**
                 * if update action lose race with delete action, return error message
                 */
                if ($pemeriksaan === null) {
                    return redirect()->intended('kader/lansia' . session('urlPagination'))->with('error', 'Data lansia sudah dihapus lebih dulu oleh kader lain');
                }
                /**
                 * implement optimistic locking, to prevent other kader update artikel in same time
                 */
                if ($pemeriksaan->updated_at > $lockingRequest->input('updated_at')) {
                    return redirect()->intended('kader/lansia' . session('urlPagination'))->with('error', 'Data lansia masih diubah oleh kader lain, coba refresh dan lakukan ubah lagi');
                }
                /**
                 * check if user has change column in pemeriksaan table
                 */
                if ($pemeriksaanRequest->all() !== []) {
                    /**
                     * fill $isUpdated to use in checking update
                     * action and clone pemeriksaan model data to
                     * retrieve original data before update also use
                     * that data in event
                     */
                    $originalPemeriksaan = clone $pemeriksaan;
                    $isUpdated = $pemeriksaan->update($pemeriksaanRequest->all());
                }

                /**
                 * lock and update with queue pemeriksaanLansia table
                 * to prevent database race condition
                 *
                 * and check if use has change column in pemeriksaan_lansias table
                 */
                $pemeriksaanLansia = PemeriksaanLansia::lockForUpdate()->find($id);
                if ($lansiaRequest->all() !== [] and $pemeriksaanLansia !== null) {
                    /**
                     * fill $isUpdated to use in checking update
                     * action and clone pemeriksaanLansia model data to
                     * retrieve original data before update also use
                     * that data in event
                     */
                    $originalLansia = clone $pemeriksaanLansia;
                    $isUpdated = PemeriksaanLansia::find($id)->update($lansiaRequest->all());
                }

                /**
                 * running event when update success to fill
                 * automatically audit_bulanan_lansias from our data
                 * updated
                 */
                event(new PemeriksaanLansiaUpdated(
                    pemeriksaan_id: $id,
                    originalPemeriksaan: $originalPemeriksaan,
                    originalPemeriksaanLansia: $originalLansia,
                    updatedPemeriksaan: $pemeriksaanRequest->all(),
                    updatedPemeriksaanLansia: $lansiaRequest->all())
                );

                return $isUpdated;
            });

            /**
             * if inside transaction had any redirect return
             */
            if (!is_bool($isUpdated)){
                return $isUpdated;
            }

            return redirect()->intended('kader/lansia' . session('urlPagination'))
                ->with('success', $isUpdated ? 'Data lansia berhasil diubah' : 'Namun Data lansia tidak diubah');

        } catch (\Throwable) {
            return redirect()->intended('kader/lansia' . session('urlPagination'))
                ->with('error', 'Terjadi Masalah Ketika mengubah Data lansia');
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
        $pemeriksaan = Pemeriksaan::find($id);
        $request->merge(['updated_at' => Carbon::make($request->input('updated_at'), 'Asia/Jakarta')->timezone('Asia/Jakarta')->format('Y-m-d H:i:s')]);
        try {
            return DB::transaction(function () use ($id, $request) {
                /**
                 * lock and delete with queue pemeriksaan table
                 * to prevent database race condition
                 */
                $pemeriksaan = Pemeriksaan::lockForUpdate()->find($id);
                if ($pemeriksaan === null) {
                    return redirect()->intended('kader/lansia' . session('urlPagination'))->with('error', 'Data lansia sudah dihapus lebih dulu oleh kader lain');
                }
                /**
                 * check if other user is update our data when we do delete action
                 */
                if ($pemeriksaan->updated_at > $request->input('updated_at')) {
                    return redirect()->intended('kader/lansia' . session('urlPagination'))->with('error', 'Data lansia masih di update oleh kader lain, coba refresh dan lakukan hapus lagi');
                }
                /**
                 * delete pemeriksaans column that also cascade to pemeriksaan_lansias column, because we use cascadeOnDelete() in migration
                 */
                $pemeriksaan->delete();

                return redirect()->intended('kader/lansia' . session('urlPagination'))->with('success', 'Data lansia berhasil dihapus');
            });
        } catch (QueryException) {
            return redirect()->intended('kader/lansia' . session('urlPagination'))->with('error', 'Data lansia gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        } catch (\Throwable) {
            return redirect()->intended('kader/lansia' . session('urlPagination'))->with('error', 'Terjadi Masalah Ketika menghapus Data lansia');
        }
    }
}
