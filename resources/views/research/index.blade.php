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
                        <div class="font-medium">Jumlah Hasil Research Pertahun (Tahun Diterima)</div>
                    </div>
                    <canvas id="dougnatchart"></canvas>
                </div>
            </div>
        </div>
        <div class="w-9/12">
            <div class="bg-white rounded py-8 px-5">
                <div class="mb-3 text-sm space-y-2">
                    <div class="font-medium">Grafik Tipe Pendanaan Reseach</div>
                    @if($tahun_diterima_selected)
                    <div>Tahun {{$tahun_diterima_selected}}</div>
                    @endif
                </div>
                <canvas id="linechart"></canvas>
            </div>
        </div>
    </div>

    <div class="block mt-10 mb-2 font-bold text-lg">
        Filter
    </div>
    <form action="research" class="flex items-end w-full mb-10 space-x-5">
        <div class="flex w-2/12">
            <div class="w-full">
                <label for="" class="block font-medium">Tahun Diterima</label>
                <select name="tahun_diterima" class="w-full py-2 rounded block" id="">
                    {{-- get request tahun --}}
                    @if($tahun_diterima_selected)
                    <option value="{{$tahun_diterima_selected}}">{{$tahun_diterima_selected}}</option>
                    @endif
                    <option value="all">ALL</option>
                    @foreach ($tahun_diterima_option as $a)
                    <option value="{{$a}}">{{$a}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="flex w-2/12">
            <div class="w-full">
                <label for="" class="block font-medium">Tahun Berakhir</label>
                <select name="tahun_berakhir" class="w-full py-2 rounded block" id="">
                    {{-- get request tahun --}}
                    @if($tahun_berakhir_selected)
                    <option value="{{$tahun_berakhir_selected}}">{{$tahun_berakhir_selected}}</option>
                    @endif
                    <option value="all">ALL</option>
                    @foreach ($tahun_berakhir_option as $a)
                    <option value="{{$a}}">{{$a}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="flex w-2/12">
            <div class="w-full">
                <label for="" class="block font-medium">Tipe Pendanaan</label>
                <select name="tipe_pendanaan" class="w-full py-2 rounded block" id="">
                    {{-- get request tahun --}}
                    @if($tipe_pendanaan_selected)
                    <option value="{{$tipe_pendanaan_selected}}">{{$tipe_pendanaan_selected}}</option>
                    @endif
                    <option value="all">ALL</option>
                    @foreach ($tipe_pendanaan_option as $a)
                    <option value="{{$a}}">{{$a}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div>
            <button type="submit" class="bg-blue-500 text-white px-5 py-2 rounded">Filter</button>
        </div>
    </form>

    <div class="bg-white p-3 rounded">
        <table id="example" class="display nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Tahun Diterima</th>
                    <th>Tahun Berakhir</th>
                    <th>TKT</th>
                    @auth
                    <th>Grant</th>
                    @endauth
                    <th>Skema</th>
                    <th>Tipe Pendanaan</th>
                    <th>Pendanaan External</th>
                    <th>Tipe External</th>
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
                    @auth
                    <td>{{$d->grant}}</td>
                    @endauth
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
