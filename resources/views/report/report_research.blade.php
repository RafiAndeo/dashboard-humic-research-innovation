@extends('report.layout_report')

@section('title')
Laporan Research
@endsection

@section('content')
<table class='table table-bordered px-3'>
    <thead>
        <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Tahun Diterima</th>
            <th>Tahun Berakhir</th>
            <th>TKT</th>
            <th>Skema</th>
            <th>Tipe Pendanaan</th>
            <th>Pendanaan Eksternal</th>
            <th>Tipe Eksternal</th>
            <th>Lama Penelitian</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <?php  $nomor=1; ?>
        @foreach ($data as $d)
        <tr>
            <td>{{$nomor}}</td>
            <td>{{$d->judul}}</td>
            <td>{{$d->tahun_diterima}}</td>
            <td>{{$d->tahun_berakhir}}</td>
            <td>{{$d->tkt}}</td>
            <td>{{$d->skema}}</td>
            <td>{{$d->tipe_pendanaan}}</td>
            <td>{{$d->pendanaan_external}}</td>
            <td>{{$d->tipe_external}}</td>
            <td>{{$d->lama_penelitian}}</td>
            <td>{{$d->keterangan}}</td>
        </tr>
        <?php $nomor++; ?>
        @endforeach
    </tbody>
</table>
@endsection
