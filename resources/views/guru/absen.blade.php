@extends('sidebarguru')

@section('content')
    <div class="container">
        <div class="row mt-5">
            <div class="col-8">
                <a href="javascript:history.back()" class="btn btn-secondary ml-2"><i class="lni lni-reply"></i> Back</a>
                <a href="{{ route('LihatAbsen') }}"  class="btn btn-success">Lihat Presensi</a>
                <a href="{{ route('PilihCetak') }}"  class="btn btn-primary">Cetak Presensi</a>
            </div>
        </div>
        <br>

        {{-- Menampilkan pesan sukses --}}
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif


        <div class="container">
            <h1 class="text-center mt-5 mb-4">Absen Kelas {{$kelas->kelas}}</h1>
            <div class="col-4"></div><br>

            {{-- Form untuk absen siswa --}}
            <form action="{{ route('TambahAbsenAction') }}" method="POST">
                @csrf

                {{-- Input Tanggal --}}
                <label for="waktu">Tanggal Absen :</label>
                <input type="date" id="waktu" name="tanggal" value="{{ old('tanggal') }}" required class="form-control">
                @error('tanggal')
                    <div class="text-danger">{{ $message }}</div>
                @enderror

                {{-- Table Data Siswa --}}
                <table class="table table-striped mt-4">
                    <thead>
                        <tr>
                            <th scope="col">NISN</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($siswa as $s)
                            <tr>
                                <td>
                                    <input type="hidden" name="nisn[]" value="{{ $s->nisn }}">
                                    {{ $s->nisn }}
                                </td>
                                <td>{{ $s->nama }}</td>
                                <td>
                                    <select name="status[]" class="form-control">
                                        <option value="Alpa">Alpa</option>
                                        <option value="Hadir">Hadir</option>
                                        <option value="Izin">Izin</option>
                                        <option value="Sakit">Sakit</option>
                                    </select>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Hidden field untuk id_kelas --}}
                <input type="hidden" name="id_kelas" value="{{ $id}}">

                {{-- Tombol Submit --}}
                <div class="button-container mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="lni lni-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
