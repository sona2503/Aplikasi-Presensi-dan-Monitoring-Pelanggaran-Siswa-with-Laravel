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
        <a href="{{ route('TambahGuruAdm') }}" class="btn btn-primary"> +Tambah Guru</a>
        </div>
    <div class="container">
        <h1 class="text-center mt-5 mb-4">Daftar Guru</h1>
        <div class="col-4">
        </div><br>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">NIP</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Kelas</th>
                    <th scope="col">Tahun Ajaran</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($guru as $g)
                    <tr>
                         <td>{{ $g->nip }}</td>
                         <td>{{ $g->nama_guru }}</td>
                         <td>{{ $g->kelas }}</td>
                         <td>{{ $g->periode }}</td>
                        <td>
                        <a href="{{ route('EditGuru', $g->nip) }}" class="btn btn-warning">
                            <i class="lni lni-pencil-alt"></i>
                        </a>
                            <a href="{{ route('HapusGuru', $g->nip) }}" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus kelas ini?')">
                                 <i class="lni lni-trash-can"></i>
                            </a>
                        </td>
                    </tr>
                 @endforeach
            </tbody>
        </table>
    </div>



@endsection
