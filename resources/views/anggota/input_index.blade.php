@extends('layout.app')

@section('title')
Manage Member
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
                        <div class="font-medium">Jumlah Fakultas Member</div>
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
        <a href="{{route('member.create')}}" class="py-2 px-4 rounded bg-green-500 space-x-2 flex text-white hover:bg-green-600">
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
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Fakultas</th>
                    <th>Pendidikan</th>
                    <th>Bidang Ilmu</th>
                    <th>Jabatan</th>
                    <th>Kelompok Keahlian</th>
                    <th>Email</th>
                    <th>Photo</th>
                    <th>Membership</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php  $nomor=1; ?>
                @foreach ($data as $d)
                <tr>
                    <td>{{$nomor}}</td>
                    <td>{{$d->NIP}}</td>
                    <td>{{$d->nama}}</td>
                    <td>{{$d->fakultas}}</td>
                    <td>{{$d->pendidikan}}</td>
                    <td>{{$d->bidang_ilmu}}</td>
                    <td>{{$d->jabatan}}</td>
                    <td>{{$d->kelompok_keahlian}}</td>
                    <td>{{$d->email}}</td>
                    <td>{{$d->photo}}</td>
                    <td>{{$d->membership}}</td>
                    <td>{{$d->status}}</td>
                    <td>
                        <div class="flex space-x-3">
                            <a href="{{route('member.edit', ['id' => $d->id])}}" class="bg-yellow-400 block rounded py-2 px-4">Edit</a>
                            <form action="{{route('member.destroy', ['id' => $d->id])}}" method="post">
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

{{-- dougnatchart --}}
<script>
const ctx3 = document.getElementById('dougnatchart');

const data3 = {
  labels: {!!$label!!},
  datasets: [{
    label: 'Jumlah Hasil Research Pertahun',
    data: {!!$total!!},
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
