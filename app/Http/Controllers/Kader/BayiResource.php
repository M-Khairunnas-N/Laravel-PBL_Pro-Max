<?php

namespace App\Http\Controllers\Kader;

use App\Events\Bayi\PemeriksaanBayiCreated;
use App\Events\Bayi\PemeriksaanBayiUpdated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Kader\Bayi\StoreBayiRequest;
use App\Http\Requests\Kader\Bayi\UpdateBayiRequest;
use App\Http\Requests\Kader\Pemeriksaan\StorePemeriksaanRequest;
use App\Http\Requests\Kader\Pemeriksaan\UpdatePemeriksaanRequest;
use App\Http\Requests\Shared\OptimisticLockingRequest;
use App\Models\Kader;
use App\Models\Pemeriksaan;
use App\Models\PemeriksaanBayi;
use App\Models\Penduduk;
use App\Services\FilterServices;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BayiResource extends Controller
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
            'title' => 'Pemeriksaan Bayi'
        ];

        $activeMenu = 'bayi';

        /**
         * Filter bayi data base filter feature
         */
        $penduduks = $this->filter->getFilteredDataBayi($request)->paginate(10);
        $penduduks->appends(request()->all());

        return view('kader.bayi.index', compact('breadcrumb', 'activeMenu', 'penduduks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View|RedirectResponse
    {
        $breadcrumb = (object) [
            'title' => 'Pemeriksaan Bayi'
        ];

        $activeMenu = 'bayi';

        /**
         * retrieve all available bayis and their parents data from penduduks table
         */
        $bayisData = Penduduk::whereRaw('TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) <= 5')->get(['penduduk_id', 'nama', 'alamat', 'NKK', 'tgl_lahir']);
        /**
         * return error message if penduduk bayi data aren't availble
         */
        if ($bayisData->count() === 0) {
            return redirect()->intended('kader/bayi' . session('urlPagination'))
                ->with('error', 'Tidak terdapat data penduduk bayi(usia 5 tahun kebawah), coba hubungi admin');
        }
        $parentsData = Penduduk::where('hubungan_keluarga', '!=', 'Anak')
            ->get(['nama', 'hubungan_keluarga', 'NKK', 'penduduk_id']);

        return view('kader.bayi.tambah', compact('breadcrumb', 'activeMenu', 'bayisData', 'parentsData'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBayiRequest $bayiRequest, StorePemeriksaanRequest $pemeriksaanRequest): RedirectResponse
    {
        $pemeriksaan = Pemeriksaan::create($pemeriksaanRequest->all());
        $bayiRequest->merge([
            'pemeriksaan_id' => $pemeriksaan->pemeriksaan_id
        ]);
        $pemeriksaanBayi = PemeriksaanBayi::create($bayiRequest->all());

        event(new PemeriksaanBayiCreated($pemeriksaan, $pemeriksaanBayi));

        return redirect()->intended('kader/bayi' . session('urlPagination'))
            ->with('success', 'Data Bayi berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View|RedirectResponse
    {
        $breadcrumb = (object) [
            'title' => 'Pemeriksaan Bayi'
        ];

        $activeMenu = 'bayi';

        /**
         * check if data available or deleted in same time
         */
        $bayiData = Pemeriksaan::with('pemeriksaan_bayi', 'penduduk')->find($id);
        if ($bayiData === null) {
            return redirect()->intended('kader/bayi' . session('urlPagination'))->with('error', 'Data bayi baru saja dihapus kader lain');
        }

        /**
         * retrieve parent data(ibu and ayah)
         */
        $parentData = Penduduk::where('NKK', $bayiData->penduduk->NKK)
            ->where('hubungan_keluarga', '!=', 'Anak')
            ->get(['nama', 'hubungan_keluarga']);
        $ibu = $parentData->firstWhere('hubungan_keluarga', 'Istri')->nama ?? 'Tidak Ada Ibu';
        $ayah = $parentData->firstWhere('hubungan_keluarga', 'Kepala Keluarga')->nama ?? 'Tidak Ada Ayah';

        /**
         * retrieve kader data that processed pemeriksaan feature
         */
        $kader = Kader::withTrashed()->find($bayiData->kader_id)->only('penduduk_id')['penduduk_id'];
        $dataKader = Penduduk::find($kader)->only(['nama', 'NIK']);

        return view('kader.bayi.detail', compact('breadcrumb', 'activeMenu', 'ibu', 'ayah', 'dataKader', 'bayiData'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View|RedirectResponse
    {
        $breadcrumb = (object) [
            'title' => 'Pemeriksaan Bayi'
        ];

        $activeMenu = 'bayi';

        /**
         * check if data available or deleted in same time
         */
        $bayiData = Pemeriksaan::with('pemeriksaan_bayi', 'penduduk')->find($id);
        if ($bayiData === null) {
            return redirect()->intended('kader/bayi' . session('urlPagination'))->with('error', 'Data bayi baru saja dihapus kader lain');
        }

        return view('kader.bayi.edit', compact('breadcrumb', 'activeMenu', 'bayiData'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBayiRequest $bayiRequest, UpdatePemeriksaanRequest $pemeriksaanRequest, OptimisticLockingRequest $lockingRequest, string $id): RedirectResponse
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
            $isUpdated = DB::transaction(function () use ($bayiRequest, $pemeriksaanRequest, $lockingRequest, $id) {
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
                $originalBayi = new Collection();

                /**
                 * lock and update with queue pemeriksaan table
                 * to prevent database race condition
                 */
                $pemeriksaan = Pemeriksaan::lockForUpdate()->find($id);
                /**
                 * if update action lose race with delete action, return error message
                 */
                if ($pemeriksaan === null) {
                    return redirect()->intended('kader/bayi' . session('urlPagination'))->with('error', 'Data Bayi sudah dihapus lebih dulu oleh kader lain');
                }
                /**
                 * implement optimistic locking, to prevent other kader update artikel in same time
                 */
                if ($pemeriksaan->updated_at > $lockingRequest->input('updated_at')) {
                    return redirect()->intended('kader/bayi' . session('urlPagination'))->with('error', 'Data bayi masih diubah oleh kader lain, coba refresh dan lakukan ubah lagi');
                }
                /**
                 * check if user has change column in pemeriksaans table
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
                 * lock and update with queue pemeriksaan table
                 * to prevent database race condition
                 *
                 * and check if use has change column in pemeriksaan_bayis table
                 */
                $pemeriksaanBayi = PemeriksaanBayi::lockForUpdate()->find($id);
                if ($bayiRequest->all() !== [] and $pemeriksaanBayi !== null) {
                    /**
                     * fill $isUpdated to use in checking update
                     * action and clone pemeriksaanBayi model data to
                     * retrieve original data before update also use
                     * that data in event
                     */
                    $originalBayi = clone $pemeriksaanBayi;
                    $isUpdated = $pemeriksaanBayi->update($bayiRequest->all());
                }

                /**
                 * running event when update success to fill
                 * automatically audit_bulanan_bayis from our data
                 * updated
                 */
                event(new PemeriksaanBayiUpdated(
                    pemeriksaan_id: $id,
                    originalPemeriksaan: $originalPemeriksaan,
                    originalPemeriksaanBayi: $originalBayi,
                    updatedPemeriksaan: $pemeriksaanRequest->all(),
                    updatedPemeriksaanBayi: $bayiRequest->all()));

                return $isUpdated;
            });

            /**
             * if inside transaction had any redirect return
             */
            if (!is_bool($isUpdated)){
                return $isUpdated;
            }

            return redirect()->intended('kader/bayi' . session('urlPagination'))
                ->with('success', $isUpdated ? 'Data Bayi berhasil diubah' : 'Namun Data Bayi tidak diubah');
        } catch (\Throwable) {
            return redirect()->intended('kader/bayi' . session('urlPagination'))
                ->with('error', 'Terjadi Masalah Ketika mengubah Data Bayi');
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
                 * lock and delete with queue pemeriksaan table
                 * to prevent database race condition
                 */
                $pemeriksaan = Pemeriksaan::lockForUpdate()->find($id);
                if ($pemeriksaan === null) {
                    return redirect()->intended('kader/bayi' . session('urlPagination'))->with('error', 'Data Bayi sudah dihapus lebih dulu oleh kader lain');
                }
                /**
                 * check if other user is update our data when we do delete action
                 */
                if ($pemeriksaan->updated_at > $request->input('updated_at')) {
                    return redirect()->intended('kader/bayi' . session('urlPagination'))->with('error', 'Data bayi masih diubah oleh kader lain, coba refresh dan lakukan hapus lagi');
                }
                /**
                 * delete pemeriksaans column that also cascade to pemeriksaan_bayis column, because we use cascadeOnDelete() in migration
                 */
                $pemeriksaan->delete();

                return redirect()->intended('kader/bayi' . session('urlPagination'))->with('success', 'Data bayi berhasil dihapus');
            });
        } catch (QueryException) {
            return redirect()->intended('kader/bayi' . session('urlPagination'))->with('error', 'Data bayi gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        } catch (\Throwable) {
            return redirect()->intended('kader/bayi')->with('error', 'Terjadi Masalah Ketika menghapus Data bayi');
        }
    }
}