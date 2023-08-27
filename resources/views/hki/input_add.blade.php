@extends('layout.app')

@section('title')
Add Data HKI
@endsection

@section('content')
<div>
    @if ($errors->any())
    @foreach ($errors->all() as $err)
        <p class="">{{ $err }}</p>
    @endforeach
@endif
    <form action="{{route('hki.store')}}" method="post" class="flex pb-10">
        @method('POST')
        @csrf
        <div class="w-1/2 space-y-4">
            <div class="space-y-2">
                <label for="tahun" class="">Tahun</label>
                <input type="number" name="tahun" value="{{old('tahun')}}" class="w-full py-2 px-4 rounded border border-black" placeholder="Tahun" required>
            </div>
            <div class="space-y-2">
                <label for="judul" class="">Judul</label>
                <input type="text" name="judul" value="{{old('judul')}}" class="w-full py-2 px-4 rounded border border-black" placeholder="Judul" required>
            </div>
            @if (Auth::user()->role != 'admin')
            <x-role_member />
            @endif
            <div class="space-y-2">
                <label for="jenis" class="">Jenis</label>
                <select name="jenis" class="w-full py-2 px-4 rounded border border-black" placeholder="Jenis">
                    <option value="MEREK">MEREK</option>
                    <option value="HAK CIPTA">HAK CIPTA</option>
                    <option value="DESAIN INDUSTRI">DESAIN INDUSTRI</option>
                    <option value="PATEN SEDERHANA">PATEN SEDERHANA</option>
                    <option value="RAHASIA DAGANG">RAHASIA DAGANG</option>
                    <option value="DESAIN TATA LETAK SIRKUIT TERPADU">DESAIN TATA LETAK SIRKUIT TERPADU</option>
                </select>
            </div>
            <div class="space-y-2">
                <label for="status" class="">Status</label>
                <select name="status" class="w-full py-2 px-4 rounded border border-black" placeholder="Status">
                    <option value="GRANTED">GRANTED</option>
                    <option value="PROCESS">PROCESS</option>
                </select>
            </div>
            <div class="space-y-2">
                <button type="submit" class="py-2 px-4 w-full bg-red-primary rounded text-white">Submit</button>
            </div>
        </div>
    </form>
</div>
@endsection
