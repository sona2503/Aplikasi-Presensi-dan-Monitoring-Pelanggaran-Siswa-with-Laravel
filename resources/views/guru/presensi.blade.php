@extends('sidebarguru')
@section('content')
<div class="container">
    <div class="row mt-5">
        <div class="container">
            <div class="col-8">
                <a href="javascript:history.back()" class="btn btn-secondary ml-2">
                    <i class="lni lni-reply"></i> Kembali
                </a>
            </div><br>

            <div class="row">
                @foreach($data as $d)
                    <!-- Tampilkan kolom data secara menyamping -->
                    <div class="col-3"><strong>Wali Kelas:</strong> {{ $d->nama_guru }}</div>
                    <div class="col-3"><strong>Kelas:</strong> {{ $d->kelas }}</div>
                    <div class="col-3"><strong>Nama Siswa:</strong> {{ $d->nama }}</div>
                    <div class="col-3"><strong>NISN:</strong> {{ $d->nisn }}</div>
                @endforeach    
            </div>

            <!-- Form Pilihan Bulan -->
            <form action="{{ route('SeleksiCetak', ['nisn' => $siswa->nisn]) }}" method="GET" class="mb-4 mt-3"> 
                <div class="row">
                    <div class="col-md-4">
                        <label for="bulan">Pilih Bulan:</label>
                        <select name="bulan" id="bulan" class="form-control">
                            <option value="">-- Pilih Bulan --</option>
                            <option value="1">Januari</option>
                            <option value="2">Februari</option>
                            <option value="3">Maret</option>
                            <option value="4">April</option>
                            <option value="5">Mei</option>
                            <option value="6">Juni</option>
                            <option value="7">Juli</option>
                            <option value="8">Agustus</option>
                            <option value="9">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </div>
                    <div class="col-md-2 align-self-end">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </form>

            <!-- Judul Kehadiran -->
            <h1 class="text-center mt-5 mb-4">Kehadiran {{ $siswa->nama }}</h1>

            <div class="col-4"></div><br>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($presensi as $pres)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($pres->tanggal)->format('d M Y') }}</td>
                            <td>{{ $pres->status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="container">
                <div class="col">
                    <a class="btn btn-primary" href="{{ route('CetakPresensi', ['nisn' => $siswa->nisn, 'bulan' => request('bulan')]) }}" role="button">Cetak</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
