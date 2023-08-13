@extends('layout.app')

@section('title')
Edit Data Partner
@endsection

@section('content')
<div>
    @if ($errors->any())
    @foreach ($errors->all() as $err)
        <p class="">{{ $err }}</p>
    @endforeach
@endif
    <form action="{{route('partner.update', ['id' => $id])}}" method="post" class="flex pb-10">
        @method('PUT')
        @csrf
        <div class="w-1/2 space-y-4">
            <div class="space-y-2">
                <label for="nama_partner" class="">Nama Partner</label>
                <input type="text" name="nama_partner" value="{{$data->nama_partner}}" class="w-full py-2 px-4 rounded border border-black" placeholder="Nama Partner" required>
            </div>
            <div class="space-y-2">
                <label for="sumber" class="">Sumber</label>
                <input type="text" name="sumber" value="{{$data->sumber}}" class="w-full py-2 px-4 rounded border border-black" placeholder="Sumber" required>
            </div>
            <div class="space-y-2">
                <label for="institusi" class="">Institusi</label>
                <input type="text" name="institusi" value="{{$data->institusi}}" class="w-full py-2 px-4 rounded border border-black" placeholder="Institusi" required>
            </div>
            <div class="space-y-2">
                <label for="jabatan" class="">Jabatan</label>
                <input type="text" name="jabatan" value="{{$data->jabatan}}" class="w-full py-2 px-4 rounded border border-black" placeholder="Jabatan" required>
            </div>
            <div class="space-y-2">
                <label for="negara" class="">Negara</label>
                <input type="text" name="negara" value="{{$data->negara}}" class="w-full py-2 px-4 rounded border border-black" placeholder="Negara" required>
            </div>
            <div class="space-y-2">
                <label for="type" class="">Type</label>
                <input type="text" name="type" value="{{$data->type}}" class="w-full py-2 px-4 rounded border border-black" placeholder="Type" required>
            </div>

            <div class="space-y-2">
                <button type="submit" class="py-2 px-4 w-full bg-red-primary rounded text-white">Submit</button>
            </div>
        </div>
    </form>
</div>
@endsection
