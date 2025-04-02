@extends('sidebaradmin')

@section('content')
<div class="container">
    <div class="row mt-5">
        <div class="container">
            <h1 class="text-center mt-5 mb-4">Daftar Pelanggaran</h1>
            
            <!-- Filter Form -->
            <form action="{{ route('TampilPelanggaranAdm') }}" method="GET">
                <div class="row mb-4">
                    <div class="col-md-4">
                        <select name="id_kelas" class="form-control">
                            <option value="">Pilih Kelas</option>
                            @foreach($kelas as $kls)
                                <option value="{{ $kls->id_kelas }}" {{ request('id_kelas') == $kls->id_kelas ? 'selected' : '' }}>
                                    {{ $kls->kelas }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </form>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Kelas</th>
                        <th scope="col">NISN</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Pelanggaran</th>
                        <th scope="col">Jenis</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pelanggaran as $data)
                        <tr>
                            <td>{{ $data->kelas }}</td>
                            <td>{{ $data->nisn }}</td>
                            <td>{{ $data->nama }}</td>
                            <td>{{ $data->pelanggaran }}</td>
                            <td>{{ $data->jenis }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
