@extends('layout.app')

@section('title')
Dashboard
@endsection

@section('content')
    <div class="grid grid-cols-4 space-x-5">
        <x-card title="Paper" :value="$paper_count" />
        <x-card title="Research" :value="$research_count"/>
        <x-card title="HKI" :value="$hki_count"/>
        <x-card title="Member" :value="$member_count"/>
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
                        <div class="font-medium">Grafik Quartile Paper</div>
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
  labels: {!! $label_quartile !!},
  datasets: [{
    label: 'Paper',
    data: {!! $value_quartile !!},
    hoverOffset: 4
  }]
};
const config2 = {
  type: 'doughnut',
  data: data2,
};
const piechart =new Chart(ctx2, config2);
</script>

{{-- dougnatchart --}}
<script>
const ctx3 = document.getElementById('dougnatchart');

const data3 = {
  labels: {!! $label_jenis !!},
  datasets: [{
    label: 'Paper',
    data: {!! $value_jenis !!},
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
    const data = {
    labels: [{{$label}}],
    datasets: [
        {
        label: 'PAPER',
        data: [{!! $paper_count_by_year !!}]
        },
        {
        label: 'HKI',
        data: [{!! $hki_count_by_year !!}]
        },
        {
        label: 'RESEARCH',
        data: [{!! $research_count_by_year !!}]
        }
    ]
    };

    const config = {
    type: 'bar',
    data: data,
    options: {
        responsive: true,
        scales: {
            x: {
                stacked: true,
            },
            y: {
                stacked: true
            }
        },
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
    }
}

    const chartline = new Chart(ctx, config);
</script>
@endsection
