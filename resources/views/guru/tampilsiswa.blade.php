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
        <a href="javascript:history.back()" class="btn btn-secondary ml-2"><i class="lni lni-reply"></i> Back</a>
        <a href="{{ route('TambahSiswa', ['id' => $id]) }}" class="btn btn-primary"> +Tambah Siswa</a>
        </div>
    <div class="container">
        <h1 class="text-center mt-5 mb-4">Daftar Siswa Kelas {{ $kelas->kelas }} </h1>
        <div class="col-4">
        </div><br>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">NISN</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($siswa as $s)
                    <tr>
                         <td>{{ $s->nisn }}</td>
                        <td>{{ $s->nama}}</td>
                        <td>
                        <a href="{{ route('EditSiswa',$s->nisn) }}" class="btn btn-warning">
                            <i class="lni lni-pencil-alt"></i>
                        </a>
                            <a href="{{ route('HapusSiswa', ['id' => $id, 'nisn' => $s->nisn]) }}" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus kelas ini?')">
                                 <i class="lni lni-trash-can"></i>
                            </a>
                        </td>
                    </tr>
                 @endforeach
            </tbody>
        </table>
    </div>



@endsection
