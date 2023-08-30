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
                        <div class="font-medium">Jumlah Hasil Paper Pertahun</div>
                    </div>
                    <canvas id="dougnatchart"></canvas>
                </div>
            </div>
        </div>
        <div class="w-9/12">
            <div class="bg-white rounded py-8 px-5">
                <div class="mb-3 text-sm space-y-2">
                    <div class="font-medium">Grafik Jenis Riset</div>
                    @if($tahun_selected)
                    <div>Tahun {{$tahun_selected}}</div>
                    @endif
                </div>
                <canvas id="linechart"></canvas>
            </div>
        </div>
    </div>


    <div class="block mt-10 mb-2 font-bold text-lg">
        Filter
    </div>
    <form action="paper" class="flex items-end w-full mb-10 space-x-5">
        <div class="flex w-2/12">
            <div class="w-full">
                <label for="" class="block font-medium">Tahun</label>
                <select name="tahun" class="w-full py-2 rounded block" id="">
                    {{-- get request tahun --}}
                    @if($quartile_selected)
                    <option value="{{$tahun_selected}}">{{$tahun_selected}}</option>
                    @endif
                    <option value="all">ALL</option>
                    @foreach ($tahun as $a)
                    <option value="{{$a}}">{{$a}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="flex w-2/12">
            <div class="w-full">
                <label for="" class="block font-medium">Quartile</label>
                <select name="quartile" class="w-full py-2 rounded block" id="">
                    {{-- get request quartile --}}
                    @if($quartile_selected)
                    <option value="{{$quartile_selected}}">{{$quartile_selected}}</option>
                    @endif
                    <option value="all">ALL</option>
                    @foreach ($quartile as $a)
                    <option value="{{$a}}">{{$a}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="flex w-2/12">
            <div class="w-full">
                <label for="" class="block font-medium">Jenis</label>
                <select name="jenis" class="w-full py-2 rounded block" id="">
                    {{-- get request quartile --}}
                    @if($jenis_selected)
                    <option value="{{$jenis_selected}}">{{$jenis_selected}}</option>
                    @endif
                    <option value="all">ALL</option>
                    @foreach ($jenis as $a)
                    <option value="{{$a}}">{{$a}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div>
            <button type="submit" class="bg-blue-500 text-white px-5 py-2 rounded">Filter</button>
        </div>
    </form>

    <div class="bg-white p-3 rounded w-full">
        <table id="example" class="display nowrap overflow-auto" style="width:100%">
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
