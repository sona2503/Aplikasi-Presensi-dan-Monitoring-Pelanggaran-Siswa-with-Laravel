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
        <div class="col-12">
            <p>Sebelum menambah data kelas anda harus menambah data tahun ajaran terbaru. Tahun ajaran sekarang : {{ $periode }} </p>
        </div>
        <div class="col-8">
        <a href="{{ route('TambahKelasAdm') }}" class="btn btn-primary"> +Tambah Kelas</a>
        <a href="{{ route('TambahPeriodeAdm') }}" class="btn btn-success"> +Tambah Tahun Ajaran</a>
        </div>
    <div class="container">
        <h1 class="text-center mt-5 mb-4">Daftar Kelas</h1>
        <div class="col-4">
        </div><br>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Nama Kelas</th>
                    <th scope="col">Periode</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kelas as $kls)
                    <tr>
                         <td>{{ $kls->kelas }}</td>
                         <td>{{ $kls->periode }}</td>
                        <td>
                        <a href="{{ route('EditKelas', $kls->id_kelas) }}" class="btn btn-warning">
                            <i class="lni lni-pencil-alt"></i>
                        </a>
                            <a href="{{ route('HapusKelas', $kls->id_kelas) }}" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus kelas ini?')">
                                 <i class="lni lni-trash-can"></i>
                            </a>
                        </td>
                    </tr>
                 @endforeach
            </tbody>
        </table>
    </div>



@endsection
