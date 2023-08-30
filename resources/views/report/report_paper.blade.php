@extends('report.layout_report')

@section('title')
Laporan Paper
@endsection

@section('content')
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
            <th>Link</th>
        </tr>
    </thead>
    <tbody>
        @php $i=1 @endphp
        @foreach($data as $p)
        <tr>
            <td>{{ $i++ }}</td>
            <td>{{$p->judul}}</td>
            <td>{{$p->jenis}}</td>
            <td>{{$p->nama_jurnal}}</td>
            <td>{{$p->issue}}</td>
            <td>{{$p->volume}}</td>
            <td>{{$p->tahun}}</td>
            <td>{{$p->quartile}}</td>
            <td>{{$p->index}}</td>
            <td>{{$p->link}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
