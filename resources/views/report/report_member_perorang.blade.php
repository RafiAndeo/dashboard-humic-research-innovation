@extends('report.layout_report')

@section('title')
Laporan {{$data->nama}}
@endsection

@section('content')

<div>Laporan Paper</div>
<table class='table table-bordered px-3'>
    <thead>
        <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Jenis</th>
            <th>Nama Jurnal</th>
            <th>Issue</th>
            <th>Volume</th>
            <th>Tahun</th>
            <th>Quartile</th>
            <th>Index</th>
            @auth
            <th>Link</th>
            @endauth
        </tr>
    </thead>
    <tbody>
        <?php  $nomor=1; ?>
        @foreach ($paper as $d)
        <tr>
            <td>{{$nomor}}</td>
            <td>{{$d->judul}}</td>
            <td>{{$d->jenis}}</td>
            <td>{{$d->nama_jurnal}}</td>
            <td>{{$d->issue}}</td>
            <td>{{$d->volume}}</td>
            <td>{{$d->tahun}}</td>
            <td>{{$d->quartile}}</td>
            <td>{{$d->index}}</td>
            @auth
            <td>{{$d->link}}</td>
            @endauth
        </tr>
        <?php $nomor++; ?>
        @endforeach

        @auth
        <?php
        if(count($paper)==0) {
            echo("<tr><td colspan='10' class='text-center'>Tidak ada data</td></tr>");
        }
        ?>
        @endauth

        @guest
        <?php
        if(count($paper)==0) {
            echo("<tr><td colspan='9' class='text-center'>Tidak ada data</td></tr>");
        }
        ?>
        @endguest

    </tbody>
</table>

<div>Laporan Research</div>
<table class='table table-bordered px-3'>
    <thead>
        <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Tahun Diterima</th>
            <th>Tahun Berakhir</th>
            <th>TKT</th>
            @auth
            <th>Grant</th>
            @endauth
            <th>Skema</th>
            <th>Tipe Pendanaan</th>
            <th>Pendanaan External</th>
            <th>Tipe External</th>
            <th>Lama Penelitian</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <?php  $nomor=1; ?>
        @foreach ($research as $d)
        <tr>
            <td>{{$nomor}}</td>
            <td>{{$d->judul}}</td>
            <td>{{$d->tahun_diterima}}</td>
            <td>{{$d->tahun_berakhir}}</td>
            <td>{{$d->tkt}}</td>
            @auth
            <td>{{$d->grant}}</td>
            @endauth
            <td>{{$d->skema}}</td>
            <td>{{$d->tipe_pendanaan}}</td>
            <td>{{$d->pendanaan_external}}</td>
            <td>{{$d->tipe_external}}</td>
            <td>{{$d->lama_penelitian}}</td>
            <td>{{$d->keterangan}}</td>
        </tr>
        <?php $nomor++; ?>
        @endforeach
        <?php
        if(count($research)==0) {
            echo("<tr><td colspan='12' class='text-center'>Tidak ada data</td></tr>");
        }
    ?>
    </tbody>
</table>

<div>Laporan HKI</div>
<table class='table table-bordered px-3'>
    <thead>
        <tr>
            <th>No</th>
            <th>Tahun</th>
            <th>Judul</th>
            <th>Jenis</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php  $nomor=1; ?>
        @foreach ($hki as $d)
        <tr>
            <td>{{$nomor}}</td>
            <td>{{$d->tahun}}</td>
            <td>{{$d->judul}}</td>
            <td>{{$d->jenis}}</td>
            <td>{{$d->status}}</td>
        </tr>
        <?php $nomor++; ?>
        @endforeach
        <?php
        if(count($hki)==0) {
            echo("<tr><td colspan='5' class='text-center'>Tidak ada data</td></tr>");
        }
        ?>
    </tbody>
</table>
@endsection
