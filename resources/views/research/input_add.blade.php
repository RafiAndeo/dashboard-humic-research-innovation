@extends('layout.app')

@section('title')
Add Data Research
@endsection

@section('content')
<div>
    @if ($errors->any())
    @foreach ($errors->all() as $err)
        <p class="">{{ $err }}</p>
    @endforeach
@endif
    <form action="{{route('research.store')}}" method="post" class="flex pb-10">
        @method('POST')
        @csrf
        <div class="w-1/2 space-y-4">
            <div class="space-y-2">
                <label for="tahun_diterima" class="">Tahun Diterima</label>
                <input type="number" name="tahun_diterima" value="{{old('tahun_diterima')}}" class="w-full py-2 px-4 rounded border border-black" placeholder="Tahun Diterima" required>
            </div>
            <div class="space-y-2">
                <label for="tahun_berakhir" class="">Tahun Berakhir</label>
                <input type="number" name="tahun_berakhir" value="{{old('tahun_berakhir')}}" class="w-full py-2 px-4 rounded border border-black" placeholder="Tahun Berakhir" required>
            </div>
            <div class="space-y-2">
                <label for="judul" class="">Judul</label>
                <input type="text" name="judul" value="{{old('judul')}}" class="w-full py-2 px-4 rounded border border-black" placeholder="Judul" required>
            </div>
            <div class="space-y-2">
                <label for="tkt" class="">TKT</label>
                <input type="number" name="tkt" value="{{old('tkt')}}" class="w-full py-2 px-4 rounded border border-black" placeholder="TKT" required>
            </div>
            <div class="space-y-2">
                <label for="grant" class="">Grant</label>
                <input type="number" name="grant" value="{{old('grant')}}" class="w-full py-2 px-4 rounded border border-black" placeholder="Grant" required>
            </div>
            <div class="space-y-2">
                <label for="skema" class="">Skema</label>
                <select type="number" name="skema" value="{{old('skema')}}" class="w-full py-2 px-4 rounded border border-black" placeholder="Skema" required>
                    <option value="INOVASI INDONESIA KHUSUS COVID 19 KEMENRISTEK/BRIN">INOVASI INDONESIA KHUSUS COVID 19 KEMENRISTEK/BRIN </option>
                    <option value="INSINAS GELOMBANG 1 TAHUN 2021">INSINAS GELOMBANG 1 TAHUN 2021 </option>
                    <option value="INSINAS TAHAP 1 TAHUN 2020">INSINAS TAHAP 1 TAHUN 2020 </option>
                    <option value="KEMENRISTEKBRIN DRPM-Penelitian Dasar Unggulan Perguruan Tinggi">KEMENRISTEKBRIN DRPM-Penelitian Dasar Unggulan Perguruan Tinggi </option>
                    <option value="KEMENRISTEKBRIN DRPM-World Class Research">KEMENRISTEKBRIN DRPM-World Class Research </option>
                    <option value="KEMITRAAN INDUSTRI TAHAP 1 TAHUN 2021">KEMITRAAN INDUSTRI TAHAP 1 TAHUN 2021 </option>
                    <option value="KERJASAMA INTERNASIONAL TAHAP 2 TAHUN 2021 (MITRA PENELITIAN)">KERJASAMA INTERNASIONAL TAHAP 2 TAHUN 2021 (MITRA PENELITIAN) </option>
                    <option value="KERJASAMA INTERNASIONAL TAHAP I TAHUN 2020 (MITRA PENELITIAN)">KERJASAMA INTERNASIONAL TAHAP I TAHUN 2020 (MITRA PENELITIAN) </option>
                    <option value="KERJASAMA INTERNASIONAL TAHAP II TAHUN 2019 (MITRA PENELITIAN)">KERJASAMA INTERNASIONAL TAHAP II TAHUN 2019 (MITRA PENELITIAN) </option>
                    <option value="KERJASAMA INTERNATIONAL 1 TAHUN 2021">KERJASAMA INTERNATIONAL 1 TAHUN 2021 </option>
                    <option value="MATCHING FUND KEDAIREKA TAHUN 2021">MATCHING FUND KEDAIREKA TAHUN 2021 </option>
                    <option value="PEKERTI YPT TAHAP 1 TAHUN 2020">PEKERTI YPT TAHAP 1 TAHUN 2020 </option>
                    <option value="PENELITIAN DASAR DAN TERAPAN TAHAP 1 TAHUN 2020">PENELITIAN DASAR DAN TERAPAN TAHAP 1 TAHUN 2020 </option>
                    <option value="PENELITIAN DASAR DAN TERAPAN TAHAP 1 TAHUN 2021">PENELITIAN DASAR DAN TERAPAN TAHAP 1 TAHUN 2021 </option>
                    <option value="Penelitian Dasar PTUPT">Penelitian Dasar PTUPT </option>
                    <option value="PENELITIAN EKSTERNAL KEMITRAAN INDUSTRI TAHUN 2021">PENELITIAN EKSTERNAL KEMITRAAN INDUSTRI TAHUN 2021 </option>
                    <option value="PENELITIAN KERSAMA INTERNASIONAL">PENELITIAN KERSAMA INTERNASIONAL </option>
                    <option value="Pengembangan startup di perguruan tinggi tahun 2021 gelombang I">Pengembangan startup di perguruan tinggi tahun 2021 gelombang I </option>
                    <option value="PPTI GELOMBANG 1 TAHUN 2021">PPTI GELOMBANG 1 TAHUN 2021 </option>
                    <option value="PRIORITAS RISET NASIONAL TAHUN 2021">PRIORITAS RISET NASIONAL TAHUN 2021 </option>
                    <option value="PROGRAM PENGEMBANGAN TEKNOLOGI INDUSTRI TAHAP II TAHUN 2020">PROGRAM PENGEMBANGAN TEKNOLOGI INDUSTRI TAHAP II TAHUN 2020 </option>
                    <option value="PUPT">PUPT </option>
                    <option value="UNGGULAN UNIVERSITAS TAHAP 2 TAHUN 2021">UNGGULAN UNIVERSITAS TAHAP 2 TAHUN 2021 </option>
                    <option value="WORLD CLASS RESEARCH">WORLD CLASS RESEARCH </option>
                </select>
            </div>
            <div class="space-y-2">
                <label for="tipe_pendanaan" class="">Tipe Pendanaan</label>
                <select name="tipe_pendanaan" id="" class="w-full py-2 px-4 rounded border border-black" placeholder="Tipe Pendanaan" required>
                    <option value="Internal">Internal</option>
                    <option value="Eksternal Nasional">Eksternal Nasional</option>
                    <option value="Eksternal Internasional">Eksternal Internasional</option>
                    <option value="Internal + Eksternal Nasional">Internal + Eksternal Nasional</option>
                    <option value="Internal + Eksternal Internasional">Internal + Eksternal Internasional</option>
                </select>
            </div>
            <div class="space-y-2">
                <label for="pendanaan_external" class="">Pendanaan External</label>
                <input type="text" name="pendanaan_external" value="{{old('pendanaan_external')}}" class="w-full py-2 px-4 rounded border border-black" placeholder="Pendanaan External" required>
            </div>
            <div class="space-y-2">
                <label for="tipe_external" class="">Tipe External</label>
                <input type="text" name="tipe_external" value="{{old('tipe_external')}}" class="w-full py-2 px-4 rounded border border-black" placeholder="Tipe External" required>
            </div>
            <div class="space-y-2">
                <label for="lama_penelitian" class="">Lama Penelitian (Tahun)</label>
                <input type="number" name="lama_penelitian" value="{{old('lama_penelitian')}}" class="w-full py-2 px-4 rounded border border-black" placeholder="Lama Penelitian (Tahun)" required>
            </div>
            <div class="space-y-2">
                <label for="keterangan" class="">Keterangan</label>
                <input type="text" name="keterangan" value="{{old('keterangan')}}" class="w-full py-2 px-4 rounded border border-black" placeholder="Keterangan" required>
            </div>
            <div class="space-y-2">
                <button type="submit" class="py-2 px-4 w-full bg-red-primary rounded text-white">Submit</button>
            </div>
        </div>
    </form>
</div>
@endsection
