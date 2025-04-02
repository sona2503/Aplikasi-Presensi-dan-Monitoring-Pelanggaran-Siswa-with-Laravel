@extends('sidebarguru')

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
                <a href="{{ route('TambahPelanggaran', ['nisn' => $nisn]) }}" class="btn btn-danger ml-2"> + Catat Pelanggaran</a>
            </div>

            <div class="container">
                <h1 class="text-center mt-5 mb-4">Daftar Pelanggaran {{ $siswa->nama }} </h1>
                <div class="col-4"></div><br>

                @if ($pelanggaran->isEmpty())
                    <div class="alert alert-success">
                        Tidak ada pelanggaran untuk siswa ini.
                    </div>
                @else
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Pelanggaran</th>
                                <th scope="col">Jenis</th>
                                <th scope="col">Detail</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pelanggaran as $pres)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($pres->waktu)->format('d M Y') }}</td>
                                    <td>{{ $pres->pelanggaran }}</td>
                                    <td>{{ $pres->jenis }}</td>
                                    <td><a class="btn btn-primary" href="{{ route('LihatDetailPelanggaran', ['id' => $pres->id_pelanggaran] ) }}" role="button">Lihat</a></td>
                                    <td>
                                        <a href="{{ route('EditPelanggaran', ['nisn' => $pres->nisn, 'id' => $pres->id_pelanggaran]) }}" class="btn btn-warning">
                                            <i class="lni lni-pencil-alt"></i>
                                        </a>
                                        <a href="{{ route('HapusPelanggaran', ['id' => $pres->id_pelanggaran, 'nisn' => $nisn]) }}" class="btn btn-danger mt-2" onclick="return confirm('Apakah Anda yakin ingin menghapus pelanggaran ini?')">
                                            <i class="lni lni-trash-can"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                <div class="container">
                    <div class="col">
                    <a class="btn btn-primary" href="{{ route('CetakPelanggaran', ['nisn' => $pres->nisn]) }}" role="button">Cetak</a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection
