@extends('layout.app')

@section('title')
Add Data Research Member
@endsection


@section('head')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
@endsection

@section('content')
<div>
    @if ($errors->any())
    @foreach ($errors->all() as $err)
        <p class="">{{ $err }}</p>
    @endforeach
@endif
    <div class="my-5 text-lg">
        <div>Judul Research : <span class="font-semibold">{{$data->judul}}</span></div>
        <div>Tahun Diterima : <span class="font-semibold">{{$data->tahun_diterima}}</span></div>
        <div>Tahun Berakhir : <span class="font-semibold">{{$data->tahun_berakhir}}</span></div>
        <div>TKT : <span class="font-semibold">{{$data->tkt}}</span></div>
    </div>
    @if (Auth::user()->role == 'admin' || $data->isVerified == false)
    <form action="{{route('research.add_member_to_research')}}" method="post" class="flex pb-10">
        @method('POST')
        @csrf
        <div class="w-1/2 space-y-4">
            <div class="space-y-2">
                <label for="member_id" class="">Member</label>
                <select name="member_id" value="{{old('member_id')}}" class="w-full py-2 px-4 rounded border border-black" placeholder="Member" required>
                    @foreach ($member as $m)
                        <option value="{{$m->id}}">{{$m->nama}} </option>
                    @endforeach
                </select>
            </div>
            <x-role_member />
            <input type="hidden" name="research_id" value="{{$id}}">
            <div class="space-y-2">
                <button type="submit" class="py-2 px-4 w-full bg-red-primary rounded text-white">Submit</button>
            </div>

        </div>
    </form>
    @endif
    <div>
        <div class="bg-white p-3 rounded">
            <table id="example" class="display nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Role</th>
                        @if (Auth::user()->role == 'admin' || $data->isVerified == false)
                        <th>Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    <?php  $nomor=1; ?>
                    @foreach ($research_member as $d)
                    <tr>
                        <td>{{$nomor}}</td>
                        <td>{{$d->nama}}</td>
                        <td>{{$d->role_member}}</td>
                        @if (Auth::user()->role == 'admin' || $data->isVerified == false)
                        <td>
                            <div class="flex space-x-3">
                                <form action="{{route('research.delete_member_from_research', ['research_id' => $id, 'member_id' => $d->member_id])}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-400 block rounded py-2 px-4">Delete</button>
                                </form>
                            </div>
                        </td>
                        @endif
                    </tr>
                    <?php $nomor++; ?>
                    @endforeach
                </tbody>
            </table>
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
@endsection
