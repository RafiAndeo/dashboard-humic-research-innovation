@extends('layout.app')

@section('title')
Dashboard
@endsection

@section('content')
    <div class="grid grid-cols-4 space-x-5">
        <x-card title="Research" value="30"/>
        <x-card title="Research" value="30"/>
        <x-card title="Research" value="30"/>
    </div>

    <div class="flex mt-10 space-x-5">
        <div class="bg-white h-1/2 w-8/12 rounded py-8 px-5">
            <div class="mb-3 text-sm space-y-2">
                <div class="font-medium">Grafik Jumlah Riset & Inovasi per Triwulan</div>
                <div>Tahun 2023</div>
            </div>
            <canvas id="linechart"></canvas>
        </div>
        <div class="w-4/12 space-y-5">
            <div class="bg-white flex justify-center py-8 rounded">
                <div class="w-9/12">
                    <div class="mb-3 text-sm space-y-2">
                        <div class="font-medium">Grafik Data Jenis Papper</div>
                    </div>
                    <canvas id="piechart"></canvas>
                </div>
            </div>
            <div class="bg-white flex justify-center py-8 rounded">
                <div class="w-9/12">
                    <div class="mb-3 text-sm space-y-2">
                        <div class="font-medium">Jumlah Hasil Research Pertahun</div>
                    </div>
                    <canvas id="dougnatchart"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
 @yield('script')

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
