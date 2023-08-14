@extends('layout.app')

@section('title')
Add Data Paper
@endsection

@section('content')
<div>
    @if ($errors->any())
    @foreach ($errors->all() as $err)
        <p class="">{{ $err }}</p>
    @endforeach
@endif
    <form action="{{route('paper.store')}}" method="post" class="flex pb-10">
        @method('POST')
        @csrf
        <div class="w-1/2 space-y-4">
            <div class="space-y-2">
                <label for="jenis" class="">Jenis</label>
                <select name="jenis" class="w-full py-2 px-4 rounded border border-black" placeholder="Jenis">
                   <option value="International Conference">International Conference</option>
                   <option value="International Journal">International Journal</option>
                   <option value="National Conference">National Conference</option>
                   <option value="National Journal">National Journal</option>
                   <option value="Book Chapter">Book Chapter</option>
                   <option value="Book ISBN">Book ISBN</option>
                </select>
            </div>
            <div class="space-y-2">
                <label for="judul" class="">Judul</label>
                <input type="text" name="judul" value="{{old('judul')}}" class="w-full py-2 px-4 rounded border border-black" placeholder="Judul" required>
            </div>
            <div class="space-y-2">
                <label for="nama_jurnal" class="">Nama Jurnal</label>
                <input type="text" name="nama_jurnal" value="{{old('nama_jurnal')}}" class="w-full py-2 px-4 rounded border border-black" placeholder="Nama Jurnal" required>
            </div>
            <div class="space-y-2">
                <label for="issue" class="">Issue</label>
                <input type="text" name="issue" value="{{old('issue')}}" class="w-full py-2 px-4 rounded border border-black" placeholder="Issue" required>
            </div>
            <div class="space-y-2">
                <label for="volume" class="">Volume</label>
                <input type="text" name="volume" value="{{old('volume')}}" class="w-full py-2 px-4 rounded border border-black" placeholder="Volume" required>
            </div>
            <div class="space-y-2">
                <label for="tahun" class="">Tahun</label>
                <input type="number" name="tahun" value="{{old('tahun')}}" class="w-full py-2 px-4 rounded border border-black" placeholder="Tahun" required>
            </div>
            <div class="space-y-2">
                <label for="quartile" class="">Quartile</label>
                <select name="quartile" class="w-full py-2 px-4 rounded border border-black" placeholder="Quartile">
                    <option value="Q1">Q1</option>
                    <option value="Q2">Q2</option>
                    <option value="Q3">Q3</option>
                    <option value="Q4">Q4</option>
                    <option value="S1">S1</option>
                    <option value="S2">S2</option>
                    <option value="S3">S3</option>
                    <option value="S4">S4</option>
                    <option value="S5">S5</option>
                    <option value="S6">S6</option>
                </select>
            </div>
            <div class="space-y-2">
                <label for="index" class="">Index</label>
                <input type="text" name="index" value="{{old('index')}}" class="w-full py-2 px-4 rounded border border-black" placeholder="Index" required>
            </div>
            <div class="space-y-2">
                <label for="link" class="">Link</label>
                <input type="text" name="link" value="{{old('link')}}" class="w-full py-2 px-4 rounded border border-black" placeholder="Link" required>
            </div>
            <div class="space-y-2">
                <button type="submit" class="py-2 px-4 w-full bg-red-primary rounded text-white">Submit</button>
            </div>
        </div>
    </form>
</div>
@endsection
