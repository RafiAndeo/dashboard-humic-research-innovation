@extends('layout.app')

@section('title')
Paper
@endsection

@section('head')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
@endsection

@section('content')
    <div class="flex space-x-5">
        <div class="w-3/12 space-y-5">
            <x-card title="Paper" :value="$count"/>
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
        <a href="{{route('paper.create')}}" class="py-2 px-4 rounded bg-green-500 space-x-2 flex text-white hover:bg-green-600">
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
                    <th>Jenis</th>
                    <th>Nama Jurnal</th>
                    <th>Issue</th>
                    <th>Volume</th>
                    <th>Tahun</th>
                    <th>Quartile</th>
                    <th>Index</th>
                    <th>Link</th>
                    @if(Auth::user()->role == 'user')
                    <th>Status</th>
                    @endif
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php  $nomor=1; ?>
                @foreach ($data as $d)
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
                    <td>{{$d->link}}</td>
                    @if(Auth::user()->role == 'user')
                    <td>
                        @if ($d->isVerified == false)
                            <div class="bg-red-400 block rounded py-2 px-4">Belum diverifikasi</div>
                        @else
                            <div class="bg-green-400 block rounded py-2 px-4">Sudah diverifikasi</div>
                        @endif

                    </td>
                    @endif
                    <td>
                        <div class="flex space-x-3">
                            @if(Auth::user()->role == 'admin')
                                @if($d->isVerified == false)
                                <a href="{{route('paper.verifikasi', ['id' => $d->id])}}" class="bg-blue-400 block rounded py-2 px-4">Verify</a>
                                @endif
                            @endif

                            <a href="{{route('paper.add_partner_to_paper_view', ['id' => (Auth::user()->role == 'admin' ? $d->id : $d->paper_id)])}}" class="bg-cyan-400 block rounded py-2 px-4">Add Partner</a>
                            <a href="{{route('paper.add_member_to_paper_view', ['id' => (Auth::user()->role == 'admin' ? $d->id : $d->paper_id)])}}" class="bg-green-400 block rounded py-2 px-4">Add Member</a>

                            @if(Auth::user()->role == 'admin' ||(Auth::user()->role == 'user' && $d->isVerified == false))
                            <a href="{{route('paper.edit', ['id' => (Auth::user()->role == 'admin' ? $d->id : $d->paper_id)])}}" class="bg-yellow-400 block rounded py-2 px-4">Edit</a>
                            <form action="{{route('paper.destroy', ['id' => (Auth::user()->role == 'admin' ? $d->id : $d->paper_id)])}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-400 block rounded py-2 px-4">Delete</button>
                            </form>
                            @endif
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
    const labels = {!! $label_jenis !!}
    const data = {
    labels: labels,
    datasets: [
        {
        label: 'Paper',
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
