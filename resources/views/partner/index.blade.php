@extends('layout.app')

@section('title')
Partner
@endsection

@section('head')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
@endsection

@section('content')
    <div class="flex space-x-5">
        <div class="w-3/12 space-y-5">
            <x-card title="Partner" :value="$count"/>
            <div class="bg-white flex justify-center py-8 rounded">
                <div class="w-10/12">
                    <div class="mb-3 text-sm space-y-2">
                        <div class="font-medium">Jumlah Negara Partner</div>
                    </div>
                    <canvas id="dougnatchart"></canvas>
                </div>
            </div>
        </div>
        <div class="w-9/12">
            <div class="bg-white rounded py-8 px-5">
                <div class="mb-3 text-sm space-y-2">
                    <div class="font-medium">Grafik Jumlah Partner</div>
                </div>
                <canvas id="linechart"></canvas>
            </div>
        </div>
    </div>
    
    <div class="block mt-10 mb-2 font-bold text-lg">
        Filter
    </div>
    <form action="partner" class="flex items-end w-full mb-10 space-x-5">
        <div class="flex w-2/12">
            <div class="w-full">
                <label for="" class="block font-medium">Institusi</label>
                <select name="institusi" class="w-full py-2 rounded block" id="">
                    {{-- get request institusi --}}
                    @if($institusi_selected)
                    <option value="{{$institusi_selected}}">{{$institusi_selected}}</option>
                    @endif
                    <option value="all">ALL</option>
                    @foreach ($institusi_option as $a)
                    <option value="{{$a}}">{{$a}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="flex w-2/12">
            <div class="w-full">
                <label for="" class="block font-medium">Jabatan</label>
                <select name="jabatan" class="w-full py-2 rounded block" id="">
                    {{-- get request tahun --}}
                    @if($jabatan_selected)
                    <option value="{{$jabatan_selected}}">{{$jabatan_selected}}</option>
                    @endif
                    <option value="all">ALL</option>
                    @foreach ($jabatan_option as $a)
                    <option value="{{$a}}">{{$a}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="flex w-2/12">
            <div class="w-full">
                <label for="" class="block font-medium">Negara</label>
                <select name="negara" class="w-full py-2 rounded block" id="">
                    {{-- get request tahun --}}
                    @if($negara_selected)
                    <option value="{{$negara_selected}}">{{$negara_selected}}</option>
                    @endif
                    <option value="all">ALL</option>
                    @foreach ($negara_option as $a)
                    <option value="{{$a}}">{{$a}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="flex w-2/12">
            <div class="w-full">
                <label for="" class="block font-medium">Type</label>
                <select name="type" class="w-full py-2 rounded block" id="">
                    {{-- get request tahun --}}
                    @if($type_selected)
                    <option value="{{$type_selected}}">{{$type_selected}}</option>
                    @endif
                    <option value="all">ALL</option>
                    @foreach ($type_option as $a)
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
                    <th>Nama Partner</th>
                    <th>Sumber</th>
                    <th>Jenis</th>
                    <th>Institusi</th>
                    <th>Jabatan</th>
                    <th>Negara</th>
                    <th>Type</th>
                </tr>
            </thead>
            <tbody>
                <?php  $nomor=1; ?>
                @foreach ($data as $d)
                <tr>
                    <td>{{$nomor}}</td>
                    <td>{{$d->partner}}</td>
                    <td>{{$d->sumber}}</td>
                    <td>{{$d->jenis}}</td>
                    <td>{{$d->institusi}}</td>
                    <td>{{$d->jabatan}}</td>
                    <td>{{$d->negara}}</td>
                    <td>{{$d->type}}</td>
                </tr>
                <?php $nomor++; ?>
                @endforeach
            </tbody>
        </table>
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
  labels: {!!$label_negara!!},
  datasets: [{
    label: 'Jumlah Hasil Research Pertahun',
    data: {!!$total_negara!!},
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
