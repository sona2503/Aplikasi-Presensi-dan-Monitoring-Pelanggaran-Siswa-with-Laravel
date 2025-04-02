@extends('sidebaradmin')
@section('content')
    <div class="container">
        <div class="row mt-5">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        {{-- Menampilkan alert jika ada pesan error --}}
        @if (session('danger'))
            <div class="alert alert-danger">
                {{ session('danger') }}
            </div>
        @endif
        <div class="col-8">
        <a href="{{ route('TambahUserAdm') }}" class="btn btn-primary"> +Tambah User</a>
        </div>
    <div class="container">
        <h1 class="text-center mt-5 mb-4">Daftar User Sistem</h1>
        <div class="col-4">
        </div><br>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Nama User</th>
                    <th scope="col">Role</th>
                    <th scope="col">Hapus</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $s)
                    <tr>
                         <td>{{ $s->user }}</td>
                         <td>{{ $s->role }}</td>
                        <td>
                            <a href="{{ route('HapusUser', ['id' => $s->id_user]) }}" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus User ini?')">
                                 <i class="lni lni-trash-can"></i>
                            </a>
                        </td>
                    </tr>
                 @endforeach
            </tbody>
        </table>
    </div>



@endsection
