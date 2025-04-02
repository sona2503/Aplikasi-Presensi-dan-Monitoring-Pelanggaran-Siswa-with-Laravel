@extends('sidebarguru')
@section('content')
    <div class="container">
        <div class="row mt-5">
    <div class="container">
        <h1 class="text-center mt-5 mb-4">Daftar Kelas</h1>
        <div class="col-4">
        </div><br>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Nama Kelas</th>
                    <th scope="col">Absensi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kelas as $kls)
                    <tr>
                         <td>{{ $kls->kelas }}</td>
                        <td>
                            <a href="{{ route('TambahAbsen', ['id' => $kls->id_kelas]) }}" class="btn btn-success">Absen</a>
                            <a href="{{ route('LihatAbsen', ['id' => $kls->id_kelas]) }}" class="btn btn-primary">Lihat</a>
                        </td>
                    </tr>
                 @endforeach
            </tbody>
        </table>
    </div>



@endsection
