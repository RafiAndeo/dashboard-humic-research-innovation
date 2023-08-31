@extends('report.layout_report')

@section('title')
Laporan HKI
@endsection

@section('content')
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
        @foreach ($data as $d)
        <tr>
            <td>{{$nomor}}</td>
            <td>{{$d->tahun}}</td>
            <td>{{$d->judul}}</td>
            <td>{{$d->jenis}}</td>
            <td>{{$d->status}}</td>
        </tr>
        <?php $nomor++; ?>
        @endforeach
    </tbody>
</table>
@endsection
