@extends('sidebarguru')
@section('content')
    <div class="container">
        <div class="row mt-5">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="col-8">
        <a href="javascript:history.back()" class="btn btn-secondary ml-2"><i class="lni lni-reply"></i> Back</a>
        </div>
    <div class="container">
        <h1 class="text-center mt-5 mb-4">Daftar Pelanggaran Siswa Kelas {{ $kelas->kelas }} </h1>
        <div class="col-4">
        </div><br>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">NISN</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Pelanggaran</th>
                </tr>
            </thead>
            <tbody>
                @foreach($siswa as $s)
                    <tr>
                         <td>{{ $s->nisn }}</td>
                         <td>{{ $s->nama}}</td>
                         <td>
                            <a href="{{ route('LihatPelanggaran', ['nisn' => $s->nisn]) }}" class="btn btn-primary">Lihat</a>
                        </td>
                    </tr>
                 @endforeach
            </tbody>
        </table>
    </div>



@endsection
