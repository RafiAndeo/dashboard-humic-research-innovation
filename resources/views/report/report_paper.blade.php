@extends('report.layout_report')

@section('title')
Laporan Paper
@endsection

@section('content')
<div class="row">
    <div class="col-4">
        <div class="row">
            <div class="col-7">
                <div class="block">Jumlah Hasil Paper Pertahun</div>
                <canvas id="dougnatchart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="row">
            <div class="col-10">
                <div class="">Grafik Jenis Riset</div>
                <canvas id="linechart"></canvas>
            </div>
        </div>
    </div>
</div>

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
            @auth
            <td>{{$p->link}}</td>
            @endauth
        </tr>
        @endforeach
    </tbody>
</table>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>$('#example').dataTable( {
    "scrollX": true
  } );</script>

{{-- PIE CHART --}}
<script>
const ctx2 = document.getElementById('piechart');
const DATA_COUNT = 5;
const NUMBER_CFG = {count: DATA_COUNT, min: 0, max: 100};


const data2 = {
  labels: [
    'Red',
    'Blue',
    'Yellow'
  ],
  datasets: [{
    label: 'My First Dataset',
    data: [300, 50, 100],
    backgroundColor: [
      'rgb(255, 99, 132)',
      'rgb(54, 162, 235)',
      'rgb(255, 205, 86)'
    ],
    hoverOffset: 4
  }]
};
const config2 = {
  type: 'pie',
  data: data2,
};
const piechart =new Chart(ctx2, config2);
</script>

{{-- dougnatchart --}}
<script>
const ctx3 = document.getElementById('dougnatchart');

const data3 = {
  labels: {{$label}},
  datasets: [{
    label: 'Jumlah Hasil Research Pertahun',
    data: {{$total}},
    hoverOffset: 4
  }]
};
const config3 = {
  type: 'pie',
  data: data3,
};

const dougnatchart =new Chart(ctx3, config3);
</script>

{{-- LINE CHART --}}
<script>
    const ctx = document.getElementById('linechart');
    const labels = ["Q1", 'Q2', 'Q3', 'Q4'];
    const data = {
    labels: {!! $label_jenis !!},
    datasets: [{
        label: 'Paper',
        data: {!! $total_jenis !!},
        hoverOffset: 4
    }]

    };

    const config = {
    type: 'bar',
    data: data,
    options: {
        responsive: true,
        plugins: {
        legend: {
            position: 'top',
            labels: {
                font: {
                    family: 'Poppins',
                },
            }
        },
        layout: {
            padding: 20,
        },
        title: {
            display: false,
            text: 'Grafik Jumlah Riset & Inovasi per Triwulan',
        }
        }
    }}

    const chartline = new Chart(ctx, config);
</script>
@endsection
