@extends('report.layout_report')

@section('title')
Laporan Research
@endsection

@section('content')
<div class="row">
    <div class="col-4">
        <div class="row">
            <div class="col-7">
                <div class="font-medium">Jumlah Hasil Research Pertahun (Tahun Diterima)</div>
                <canvas id="dougnatchart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="row">
            <div class="col-10">
                <div class="font-medium">Grafik Tipe Pendanaan Reseach</div>
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

@section('script')
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$('#example').dataTable( {
  "scrollX": true
} );
</script>

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
  labels: {!! $label_tahun_diterima !!},
  datasets: [{
    label: 'Research',
    data: {!! $total_tahun_diterima !!},
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
    const labels = {!! $label_tipe_pendanaan !!}
    const data = {
    labels: labels,
    datasets: [
        {
        label: 'Research',
        data: {!! $total_tipe_pendanaan !!}
        }
    ]
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
