@extends('layout.app')

@section('title')
Anggota
@endsection

@section('head')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
@endsection

@section('content')
    <div class="flex space-x-5">
        <div class="w-3/12 space-y-5">
            <x-card title="Member" :value="$count"/>
            <div class="bg-white flex justify-center py-8 rounded">
                <div class="w-10/12">
                    <div class="mb-3 text-sm space-y-2">
                        <div class="font-medium">Grafik Pendidikan</div>
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

    <div class="block mt-10 mb-2 font-bold text-lg">
        Filter
    </div>
    <form action="member" class="flex items-end w-full mb-10 space-x-5">
        <div class="flex w-2/12">
            <div class="w-full">
                <label for="" class="block font-medium">Fakultas</label>
                <select name="fakultas" class="w-full py-2 rounded block" id="">
                    @if($fakultas_selected)
                    <option value="{{$fakultas_selected}}">{{$fakultas_selected}}</option>
                    @endif
                    <option value="all">ALL</option>
                    @foreach ($fakultas_option as $a)
                    <option value="{{$a}}">{{$a}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="flex w-2/12">
            <div class="w-full">
                <label for="" class="block font-medium">Pendidikan</label>
                <select name="pendidikan" class="w-full py-2 rounded block" id="">
                    {{-- get request tahun --}}
                    @if($pendidikan_selected)
                    <option value="{{$pendidikan_selected}}">{{$pendidikan_selected}}</option>
                    @endif
                    <option value="all">ALL</option>
                    @foreach ($pendidikan_option as $a)
                    <option value="{{$a}}">{{$a}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="flex w-2/12">
            <div class="w-full">
                <label for="" class="block font-medium">Kelompok Keahlian</label>
                <select name="kelompok_keahlian" class="w-full py-2 rounded block" id="">
                    {{-- get request tahun --}}
                    @if($kelompok_keahlian_selected)
                    <option value="{{$kelompok_keahlian_selected}}">{{$kelompok_keahlian_selected}}</option>
                    @endif
                    <option value="all">ALL</option>
                    @foreach ($kelompok_keahlian_option as $a)
                    <option value="{{$a}}">{{$a}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <button type="submit" class="bg-blue-500 text-white px-5 py-2 rounded">Filter</button>
        </div>
    </form>

    <div class="py-3">
        <div class="grid grid-cols-4 gap-4">
            @foreach ($data as $d)
            <div class="rounded">
                @if($d->photo == null)
                <img src="/storage/default.png" alt="" srcset="">
                @else
                <img src="{{$d->photo}}" class="w-full h-72" alt="" srcset="">
                @endif
                <div class="space-y-1 p-2 border-b border-l border-r border-black h-32">
                    <div class="font-bold">{{$d->nama}}</div>
                    <div class="text-gray-500 text-sm">
                        <div>{{$d->pendidikan}} {{$d->fakultas}}</div>
                        <div>{{$d->jabatan}}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
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
