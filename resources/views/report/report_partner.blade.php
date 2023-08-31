@extends('report.layout_report')

@section('title')
Laporan Partner
@endsection

@section('content')
<table class="table table-bordered px-3">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Partner</th>
            <th>Sumber</th>
            <th>Institusi</th>
            <th>Jabatan</th>
            <th>Negara</th>
            <th>Type</th>
        </tr>
    </thead>
    <tbody>
        <?php  $nomor=1; ?>
        @foreach ($data as $d)
        <tr>
            <td>{{$nomor}}</td>
            <td>{{$d->nama_partner}}</td>
            <td>{{$d->sumber}}</td>
            <td>{{$d->institusi}}</td>
            <td>{{$d->jabatan}}</td>
            <td>{{$d->negara}}</td>
            <td>{{$d->type}}</td>
        </tr>
        <?php $nomor++; ?>
        @endforeach
    </tbody>
</table>
@endsection
