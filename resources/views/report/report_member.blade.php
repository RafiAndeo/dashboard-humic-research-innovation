@extends('report.layout_report')

@section('title')
Laporan Member
@endsection

@section('content')

<table class="table table-bordered px-3">
    <thead>
        <tr>
            <th>No</th>
            @auth
            <th>NIP</th>
            @endauth
            <th>Nama</th>
            <th>Fakultas</th>
            <th>Pendidikan</th>
            <th>Bidang Ilmu</th>
            <th>Jabatan</th>
            <th>Kelompok Keahlian</th>
            @auth
            <th>Email</th>
            @endauth
            <th>Photo</th>
            <th>Membership</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php  $nomor=1; ?>
        @foreach ($data as $d)
        <tr>
            <td>{{$nomor}}</td>
            @auth
            <td>{{$d->NIP}}</td>
            @endauth
            <td>{{$d->nama}}</td>
            <td>{{$d->fakultas}}</td>
            <td>{{$d->pendidikan}}</td>
            <td>{{$d->bidang_ilmu}}</td>
            <td>{{$d->jabatan}}</td>
            <td>{{$d->kelompok_keahlian}}</td>
            @auth
            <td>{{$d->email}}</td>
            @endauth
            <td>{{$d->photo}}</td>
            <td>{{$d->membership}}</td>
            <td>{{$d->status}}</td>
        </tr>
        <?php $nomor++; ?>
        @endforeach
    </tbody>
</table>
@endsection
