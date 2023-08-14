@extends('layout.app')

@section('title')
Research
@endsection

@section('head')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
@endsection

@section('content')
    <div class="flex space-x-5">
        <div class="w-3/12 space-y-5">
            <x-card title="Research" :value="$count"/>
            <div class="bg-white flex justify-center py-8 rounded">
                <div class="w-10/12">
                    <div class="mb-3 text-sm space-y-2">
                        <div class="font-medium">Jumlah Hasil Research Pertahun</div>
                    </div>
                    <canvas id="dougnatchart"></canvas>
                </div>
            </div>
        </div>
        <div class="w-9/12">
            <div class="bg-white rounded py-8 px-5">
                <div class="mb-3 text-sm space-y-2">
                    <div class="font-medium">Grafik Jumlah Riset & Inovasi per Triwulan</div>
                    <div>Tahun 2023</div>
                </div>
                <canvas id="linechart"></canvas>
            </div>
        </div>
    </div>

    <div class="flex mt-10 space-x-5 mb-4">
        <a href="{{route('research.create')}}" class="py-2 px-4 rounded bg-green-500 space-x-2 flex text-white hover:bg-green-600">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
              </svg>
            <span>Tambah Data</span>
        </a>
    </div>

    <div class="bg-white p-3 rounded">
        <table id="example" class="display nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Tahun Diterima</th>
                    <th>Tahun Berakhir</th>
                    <th>TKT</th>
                    <th>Grant</th>
                    <th>Skema</th>
                    <th>Tipe Pendanaan</th>
                    <th>Pendanaan External</th>
                    <th>Tipe External</th>
                    <th>Lama Penelitian</th>
                    <th>Keterangan</th>
                    <th>Action</th>
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
                    <td>{{$d->grant}}</td>
                    <td>{{$d->skema}}</td>
                    <td>{{$d->tipe_pendanaan}}</td>
                    <td>{{$d->pendanaan_external}}</td>
                    <td>{{$d->tipe_external}}</td>
                    <td>{{$d->lama_penelitian}}</td>
                    <td>{{$d->keterangan}}</td>
                    <td>
                        <div class="flex space-x-3">
                            @if($d->isVerified == 0)
                            <a href="{{route('research.verifikasi', ['id' => $d->id])}}" class="bg-blue-400 block rounded py-2 px-4">Verify</a>
                            @endif
                            <a href="{{route('research.add_partner_to_research_view', ['id' => $d->id])}}" class="bg-cyan-400 block rounded py-2 px-4">Add Partner</a>
                            <a href="{{route('research.add_member_to_research_view', ['id' => $d->id])}}" class="bg-green-400 block rounded py-2 px-4">Add Member</a>
                            <a href="{{route('research.show', ['id' => $d->id])}}" class="bg-yellow-400 block rounded py-2 px-4">Edit</a>
                            <form action="{{route('research.destroy', ['id' => $d->id])}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-400 block rounded py-2 px-4">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php $nomor++; ?>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
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
  labels: {{$tahun_diterima_0}},
  datasets: [{
    label: 'Jumlah Hasil Research Pertahun',
    data: {{$tahun_diterima_1}},
    backgroundColor: [
      'rgb(255, 99, 132)',
      'rgb(54, 162, 235)',
      'rgb(255, 205, 86)'
    ],
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
    labels: labels,
    datasets: [
        {
        label: 'HKI',
        data: ["0",'2','3',"4",'4','5']
        },
        {
        label: 'PUBLIKASI',
        data: ["2",'4','10',100]
        }
    ]
    };

    const config = {
    type: 'line',
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
