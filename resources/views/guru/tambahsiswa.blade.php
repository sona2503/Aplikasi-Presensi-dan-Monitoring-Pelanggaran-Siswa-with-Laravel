@extends('sidebaradmin')

@section('content')
    <div class="form-container mt-4">
        <h1>Input Data Siswa</h1>
        
        {{-- Form yang mengarah ke route TambahSiswaAction --}}
        <form action="{{ route('TambahSiswaAction') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="id_kelas" value="{{ $id }}">

            {{-- Input NISN --}}
            <label for="nisn">NISN :</label>
            <input type="text" id="nisn" name="nisn" value="{{ old('nisn') }}" required>
            @error('nisn')
                <div class="text-danger">{{ $message }}</div>
            @enderror

            {{-- Input Nama Siswa --}}
            <label for="nama">Nama Siswa :</label>
            <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required>
            @error('nama')
                <div class="text-danger">{{ $message }}</div>
            @enderror

            {{-- Input Tempat Lahir --}}
            <label for="tempat_lahir">Tempat Lahir :</label>
            <input type="text" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required>
            @error('tempat_lahir')
                <div class="text-danger">{{ $message }}</div>
            @enderror

            {{-- Input Tanggal Lahir --}}
            <label for="tanggal_lahir">Tanggal Lahir :</label>
            <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
            @error('tanggal_lahir')
                <div class="text-danger">{{ $message }}</div>
            @enderror

            {{-- Tombol Submit dan Batal --}}
            <div class="button-container mt-3">
                <button id="submit_button" type="submit" class="btn btn-primary">
                    <i class="lni lni-save" style="vertical-align: middle; margin-right: 2px;"></i>
                    <span style="vertical-align: middle;">Simpan</span>
                </button>
                <button type="button" class="btn btn-danger float-left" onclick="goBack()">
                    <i class="lni lni-arrow-left-circle" style="vertical-align: middle; margin-right: 2px;"></i>
                    <span style="vertical-align: middle;">Batal</span>
                </button>
            </div>
        </form>
    </div>
@endsection

<script>
    function goBack() {
        window.history.back();
    }
</script>
