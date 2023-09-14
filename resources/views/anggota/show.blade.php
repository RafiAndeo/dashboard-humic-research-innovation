@extends('layout.app')

@section('title')
{{$data->nama}} - {{$data->jabatan}}
@endsection

@section('head')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
@endsection

@section('content')
    <div class="flex w-full space-x-5">
        <div class="w-2/6">
            @if($data->photo == null)
                <img src="/storage/default.png" alt="" srcset="">
            @else
                <img src="{{$data->photo}}" class=" h-72" alt="" srcset="">
            @endif
        </div>
        <div class="w-full">
            <div class="flex">
                <div class="w-1/2 space-y-4">
                    <div>
                        @auth
                        <div class="font-medium">NIP</div>
                        <div>{{$data->NIP}}</div>
                        @endauth
                    </div>
                    <div>
                        <div class="font-medium">Fakultas</div>
                        <div>{{$data->fakultas}}</div>
                    </div>
                    <div>
                        <div class="font-medium">Pendidikan</div>
                        <div>{{$data->pendidikan}}</div>
                    </div>
                    <div>
                        <div class="font-medium">Bidang Ilmu</div>
                        <div>{{$data->bidang_ilmu}}</div>
                    </div>
                </div>
                <div class="w-1/2 space-y-4">
                    <div>
                        <div class="font-medium">Jabatan</div>
                        <div>{{$data->jabatan}}</div>
                    </div>
                    <div>
                        <div class="font-medium">Kelompok Keahlian</div>
                        <div>{{$data->kelompok_keahlian}}</div>
                    </div>
                    <div>
                        <div class="font-medium">Membership</div>
                        <div>{{$data->membership}}</div>
                    </div>
                    <div>
                        <div class="font-medium">Status</div>
                        <div>{{$data->status}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-10">
        <a href="{{route('report.membershow', ['id' => $data->id])}}" class="bg-green-500 hover:bg-green-600 hover:cursor-pointer text-white px-5 py-2 rounded">Download Report</a>
    </div>
    <div class="my-5 space-y-4">
        <div class="font-semibold text-xl">Data Paper</div>
        <div>
            <div class="bg-white p-3 rounded w-full">
                <table id="paper" class="display nowrap overflow-auto" style="width:100%">
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
                            @auth
                            <th>Link</th>
                            @endauth
                        </tr>
                    </thead>
                    <tbody>
                        <?php  $nomor=1; ?>
                        @foreach ($paper as $d)
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
                            @auth
                            <td>{{$d->link}}</td>
                            @endauth
                        </tr>
                        <?php $nomor++; ?>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="my-5 space-y-4">
        <div class="font-semibold text-xl">Data Research</div>
        <div>
            <div class="bg-white p-3 rounded">
                <table id="research" class="display nowrap" style="width:100%">
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
                        @foreach ($research as $d)
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
    </div>



    <div class="my-5 space-y-4">
        <div class="font-semibold text-xl">Data HKI</div>
        <div class="bg-white p-3 rounded">
            <table id="hki" class="display nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tahun</th>
                        <th>Judul</th>
                        <th>Jenis</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php  $nomor=1; ?>
                    @foreach ($hki as $d)
                    <tr>
                        <td>{{$nomor}}</td>
                        <td>{{$d->tahun}}</td>
                        <td>{{$d->judul}}</td>
                        <td>{{$d->jenis}}</td>
                        <td>{{$d->status}}</td>
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
    $('#paper').dataTable( {
      "scrollX": true
    } );
    $('#hki').dataTable( {
      "scrollX": true
    } );
    $('#research').dataTable( {
      "scrollX": true
    } );
    </script>
@endsection
