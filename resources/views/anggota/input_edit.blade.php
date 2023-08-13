@extends('layout.app')

@section('title')
Add Data Member
@endsection

@section('content')
<div>
    @if ($errors->any())
    @foreach ($errors->all() as $err)
        <p class="">{{ $err }}</p>
    @endforeach
@endif
    <form action="{{route('member.update', ['id' => $id])}}" method="post" class="flex pb-10">
        @method('PUT')
        @csrf
        <div class="w-1/2 space-y-4">
            <div class="space-y-2">
                <label for="NIP" class="">NIP</label>
                <input type="number" name="NIP" value="{{$data->NIP}}" class="w-full py-2 px-4 rounded border border-black" placeholder="NIP" required>
            </div>
            <div class="space-y-2">
                <label for="nama" class="">Nama</label>
                <input type="text" name="nama" value="{{$data->nama}}" class="w-full py-2 px-4 rounded border border-black" placeholder="Nama" required>
            </div>
            <div class="space-y-2">
                <label for="fakultas" class="">Fakultas</label>
                <input type="text" name="fakultas" value="{{$data->fakultas}}" class="w-full py-2 px-4 rounded border border-black" placeholder="Fakultas" required>
            </div>
            <div class="space-y-2">
                <label for="pendidikan" class="">Pendidikan</label>
                <input type="text" name="pendidikan" value="{{$data->pendidikan}}" class="w-full py-2 px-4 rounded border border-black" placeholder="Pendidikan" required>
            </div>
            <div class="space-y-2">
                <label for="bidang_ilmu" class="">Bidang Ilmu</label>
                <input type="text" name="bidang_ilmu" value="{{$data->bidang_ilmu}}" class="w-full py-2 px-4 rounded border border-black" placeholder="Bidang Ilmu" required>
            </div>
            <div class="space-y-2">
                <label for="jabatan" class="">Jabatan</label>
                <input type="text" name="jabatan" value="{{$data->jabatan}}" class="w-full py-2 px-4 rounded border border-black" placeholder="Jabatan" required>
            </div>
            <div class="space-y-2">
                <label for="kelompok_keahlian" class="">Kelompok Keahlian</label>
                <input type="text" name="kelompok_keahlian" value="{{$data->kelompok_keahlian}}" class="w-full py-2 px-4 rounded border border-black" placeholder="Kelompok Keahlian" required>
            </div>
            <div class="space-y-2">
                <label for="email" class="">Email</label>
                <input type="email" name="email" value="{{$data->email}}" class="w-full py-2 px-4 rounded border border-black" placeholder="Email" required>
            </div>
            <div class="space-y-2">
                <label for="photo" class="">Photo</label>
                <input type="text" name="photo" value="{{$data->photo}}" class="w-full py-2 px-4 rounded border border-black" placeholder="Photo" required>
            </div>
            <div class="space-y-2">
                <label for="membership" class="">Membership</label>
                <input type="text" name="membership" value="{{$data->membership}}" class="w-full py-2 px-4 rounded border border-black" placeholder="Membership" required>
            </div>
            <div class="space-y-2">
                <label for="status" class="">Status</label>
                <input type="text" name="status" value="{{$data->status}}" class="w-full py-2 px-4 rounded border border-black" placeholder="Status" required>
            </div>
            <div class="space-y-2">
                <label for="role" class="">Role</label>
                <select name="role" class="w-full py-2 px-4 rounded border border-black" required>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <div class="space-y-2">
                <button type="submit" class="py-2 px-4 w-full bg-red-primary rounded text-white">Submit</button>
            </div>
        </div>
    </form>
</div>
@endsection
