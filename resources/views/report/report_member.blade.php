@extends('report.layout_report')

@section('title')
Laporan Member
@endsection

@section('content')
<div class="row">
    <div class="col-4">
        <div class="row">
            <div class="col-7">
                <div class="font-medium">Grafik Pendidikan</div>
                <canvas id="dougnatchart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="row">
            <div class="col-10">
                <div class="font-medium">Grafik Jumlah Anggota per Fakultas</div>
                <canvas id="linechart"></canvas>
            </div>
        </div>
    </div>
</div>
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
  labels: {!! $label_pendidikan !!},
  datasets: [{
    label: 'My First Dataset',
    data: {!! $total_pendidikan !!},
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
    const labels = {!! $label_fakultas !!};
    const data = {
    labels: labels,
    datasets: [
        {
        label: 'Fakultas',
        data: {!! $total_fakultas !!},
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
