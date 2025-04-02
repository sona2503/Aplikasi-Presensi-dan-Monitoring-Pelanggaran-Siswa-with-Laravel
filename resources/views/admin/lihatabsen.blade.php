@extends('sidebaradmin')
@section('content')
    <div class="container">
        <div class="row mt-5">
            <div class="col-8">
                <a href="javascript:history.back()" class="btn btn-secondary ml-2"><i class="lni lni-reply"></i> Back</a>
            </div>
        </div>
        <div class="container">
            <h1 class="text-center mt-5 mb-4">Presensi Kelas {{ $kelas->kelas }}</h1>
            
            <!-- Form untuk filter bulan -->
            <form action="{{ route('LihatAbsenAdm', ['id' => $kelas->id_kelas]) }}" method="GET" class="mb-4">
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

            <!-- Tabel presensi -->
            @php
                $currentDate = null;
            @endphp

            @foreach($presensi as $pres)
                @if ($currentDate !== $pres->tanggal)
                    @if ($currentDate !== null)
                        </tbody>
                        </table>
                    @endif
                    {{-- Tampilkan header tanggal baru --}}
                    <h5 class="text-left mt-5 mb-4">Tanggal Presensi : {{ \Carbon\Carbon::parse($pres->tanggal)->format('d M Y') }}</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">NISN</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                    @php
                        $currentDate = $pres->tanggal;
                    @endphp
                @endif
                {{-- Tampilkan data siswa untuk tanggal tersebut --}}
                <tr>
                    <td>{{ $pres->nisn }}</td>
                    <td>{{ $pres->nama }}</td>
                    <td>{{ $pres->status }}</td>
                </tr>
            @endforeach
            </tbody>
            </table>
        </div>
    </div>
@endsection
