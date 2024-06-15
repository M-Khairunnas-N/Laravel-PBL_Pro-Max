@extends('promosi.template')

@section('content')
    <p class="font-bold text-2xl sm:text-3xl md:text-4xl text-center py-4 md:py-8">Posyandu</p>
    <div class="flex flex-col md:flex-row bg-white rounded-lg mx-4 md:mx-14 gap-6 md:gap-10">
        <img class="w-full md:w-1/2 h-auto py-4 md:py-10 md:pl-10" src="{{ asset('img/logo_posyandu.png') }}" alt="logo posyandu">
        <div class="flex flex-col gap-6 md:gap-8 pr-4 md:pr-10 justify-center ">
            <h2 class="font-bold text-2xl md:text-3xl px-10">Apa itu Posyandu?</h2>
            <p class="text-base md:text-lg lg:text-xl text-justify px-10 pb-10">Pos Pelayanan Terpadu adalah suatu kegiatan perwujudan peran serta masyarakat yang dikelola oleh masyarakat, dari masyarakat, dan untuk masyarakat dalam mencapai pelayanan kesehatan yang lebih baik.</p>
        </div>
    </div>

    <p class="font-bold text-2xl sm:text-3xl md:text-4xl text-center py-4 md:py-8">Visi dan Misi</p>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-14 h-full px-4 md:px-14">
        <div class="flex flex-col items-center rounded-lg h-full px-6 md:px-10 bg-white gap-8 md:gap-10">
            <div class="flex flex-col items-center gap-6 md:gap-8">
                <img src="{{ asset('img/Vision board-amico.png') }}" alt="Vision" class="w-28 md:w-52 aspect-square pt-6 md:pt-10">
                <h2 class="font-bold text-xl md:text-2xl">Visi</h2>
            </div>
            <div class="px-4 md:px-8">
                <ul class="list-disc space-y-4 text-justify text-base md:text-lg lg:text-xl pb-10">
                    <li>Mewujudkan pelayanan kesehatan yang optimal di Posyandu Delima Merah</li>
                    <li>Mewujudkan program prioritas nasional yaitu menurunkan angka kematian ibu dan bayi, percepatan penurunan stunting, dan meningkatkan pencapaian posyandu.</li>
                </ul>
            </div>
        </div>
        <div class="flex flex-col items-center rounded-lg px-6 md:px-10 bg-white gap-8 md:gap-10">
            <div class="flex flex-col items-center gap-6 md:gap-8">
                <img src="{{ asset('img/Business mission-amico.png') }}" alt="Mission" class="w-28 md:w-52 aspect-square pt-6 md:pt-10">
                <h2 class="font-bold text-xl md:text-2xl">Misi</h2>
            </div>
            <div class="px-4 md:px-8">
                <ul class="list-disc space-y-4 text-justify text-base md:text-lg lg:text-xl pb-10">
                    <li>Meningkatkan pemerataan pelayanan kesehatan kepada masyarakat</li>
                    <li>Meningkatkan jangkauan pelayanan kesehatan dengan pendekatan proaktif</li>
                    <li>Meningkatkan mutu layanan kesehatan masyarakat di wilayah Kelurahan Polehan RW 06</li>
                </ul>   
            </div>
        </div>
    </div>

    <p class="font-bold text-2xl sm:text-3xl md:text-4xl text-center py-4 md:py-8">Kegiatan</p>
    <div class="mx-4 md:mx-14 bg-white rounded-lg mb-6 md:mb-14">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8 h-full px-6 md:px-12 py-6 md:py-10">
            <div class="flex flex-col items-center text-white h-full bg-[#32A0C0] gap-6 md:gap-10 py-6 md:py-12 rounded-md">
                <p class="text-xl md:text-2xl lg:text-3xl">Posyandu Balita</p>
                <div class="px-6 md:px-10">
                    <ul class="list-disc space-y-4 text-justify text-base md:text-lg lg:text-xl font-semibold px-8">
                        <li>Penimbangan Berat Badan</li>
                        <li>Penentuan Status Pertumbuhan</li>
                        <li>Pengisian Buku KMS</li>
                        <li>Penyuluhan</li>
                        <li>Pelayanan Imunisasi</li>
                        <li>Pemberian Makanan Tambahan (PTM)</li>
                    </ul>
                </div>
            </div>
            <div class="flex flex-col items-center text-white h-full bg-[#5BB3CC] gap-6 md:gap-10 py-6 md:py-12 rounded-md">
                <p class="text-xl md:text-2xl lg:text-3xl">Posyandu Lansia</p>
                <div class="px-6 md:px-10">
                    <ul class="list-disc space-y-4 text-justify text-base md:text-lg lg:text-xl font-semibold px-8">
                        <li>Penimbangan Berat Badan</li>
                        <li>Pengukuran Tinggi Badan</li>
                        <li>Pengecekan Tekanan Darah</li>
                        <li>Pengukuran Lingkar Perut</li>
                    </ul>
                </div>
            </div>
            <div class="flex flex-col items-center text-white h-full bg-[#84C6D9] gap-6 md:gap-10 py-6 md:py-12 rounded-md">
                <p class="text-xl md:text-2xl lg:text-3xl">Kegiatan Penunjang</p>
                <div class="px-6 md:px-12">
                    <ul class="list-disc space-y-4 text-justify text-base md:text-lg lg:text-xl font-semibold px-8">
                        <li>Kelas Ibu Hamil</li>
                        <li>Pencegahan Diare</li>
                        <li>Team Pendamping Keluarga</li>
                        <li>Pemeriksaan Gula Darah Gratis</li>
                        <li>Imunisasi Lengkap Di Pos Kesehatan Kelurahan Polehan</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
