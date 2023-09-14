@extends('report.layout_report')

@section('title')
Laporan HKI
@endsection

@section('content')
<div class="row">
    <div class="col-4">
        <div class="row">
            <div class="col-7">
                <div class="font-medium">Grafik HKI Pertahun</div>
                <canvas id="dougnatchart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="row">
            <div class="col-10">
                <div class="font-medium">Grafik Jenis HKI</div>
                <canvas id="linechart"></canvas>
            </div>
        </div>
    </div>
</div>
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


@section('script')
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $('#example').dataTable( {
  "scrollX": true
} );
</script>


{{-- dougnatchart --}}
<script>
const ctx3 = document.getElementById('dougnatchart');

const data3 = {
  labels: {!! $label_tahun !!},
  datasets: [{
    label: 'HKI',
    data: {!! $total_tahun !!},
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
    const labels = {!! $label_jenis !!}
    const data = {
    labels: labels,
    datasets: [
        {
        label: 'HKI',
        data: {!! $total_jenis !!}
        },
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
