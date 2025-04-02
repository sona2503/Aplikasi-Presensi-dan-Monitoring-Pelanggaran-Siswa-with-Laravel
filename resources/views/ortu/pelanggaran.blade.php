@extends('sidebarortu')

@section('content')
    <div class="container">
        <div class="row mt-5">
            <div class="container">

                <div class="col-8">
                    <a href="javascript:history.back()" class="btn btn-secondary ml-2">
                        <i class="lni lni-reply"></i> Back
                    </a> 
                </div><br>
                                
            {{-- Menampilkan alert jika ada pesan error --}}
                @if (session('warning'))
                    <div class="alert alert-warning">
                        {{ session('warning') }}
                    </div>
                @endif<br>

                <div class="row">
                    @foreach($data as $d)
                        <div class="col-3"><strong>Wali Kelas:</strong> {{ $d->nama_guru }}</div>
                        <div class="col-3"><strong>Kelas:</strong> {{ $d->kelas }}</div>
                        <div class="col-3"><strong>Nama Siswa:</strong> {{ $d->nama }}</div>
                        <div class="col-3"><strong>NISN:</strong> {{ $d->nisn }}</div>
                    @endforeach    
                </div>

                <h1 class="text-center mt-5 mb-4">Pelanggaran {{ $siswa->nama }}</h1>
                <div class="col-4"></div><br>
                
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Pelanggaran</th>
                            <th scope="col">Jenis</th>
                            <th scope="col">Catatan</th>
                            <th scope="col">Point</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($pelanggaran->isEmpty())
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada pelanggaran.</td>
                            </tr>
                        @else
                            @foreach($pelanggaran as $pres)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($pres->waktu)->format('d M Y') }}</td>
                                    <td>{{ $pres->pelanggaran }}</td>
                                    <td>{{ $pres->jenis }}</td>
                                    <td>{{ $pres->catatan }}</td>
                                    <td>{{ $pres->point }}</td>
                                </tr>
                            @endforeach    
                    </tbody>
                </table>
                <div class="container">
    <div class="col">
        <a class="btn btn-primary" href="{{ route('CetakPelanggaranOrtu') }}" role="button">Cetak</a>
    </div>
</div>

                @endif

                <div class="d-flex justify-content-center mt-4">
                    <div class="card text-center" style="width: 14rem;">
                        <div class="card-body">
                            <h5 class="card-title">Total Poin</h5>
                            <p class="card-text" style="font-size: 2rem;">{{ $totalPoint }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
