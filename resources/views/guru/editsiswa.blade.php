@extends('sidebarguru')

@section('content')
    <div class="form-container mt-4">
        <h1>Edit Data Siswa</h1>

        {{-- Form yang mengarah ke route UpdateSiswaAction --}}
        <form action="{{ route('UpdateSiswaAction') }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Input untuk NISN yang bisa diubah --}}
            <label for="nisn">NISN :</label>
            <input type="text" id="nisn" name="nisn" value="{{ old('nisn', $siswa->nisn) }}" required>
            @error('nisn')
                <div class="text-danger">{{ $message }}</div>
            @enderror

            {{-- Input hidden untuk NISN lama --}}
            <input type="hidden" name="old_nisn" value="{{ $siswa->nisn }}">

            {{-- Dropdown untuk memilih Kelas --}}
            <label for="id_kelas">Pilih Kelas :</label>
            <select id="id_kelas" name="id_kelas" required>
                <option value="" disabled>Pilih Kelas</option>
                @foreach($select as $kelas)  {{-- Mengambil data kelas dari controller --}}
                    <option value="{{ $kelas->id_kelas }}" {{ old('id_kelas', $siswa->id_kelas) == $kelas->id_kelas ? 'selected' : '' }}>
                        {{ $kelas->kelas }} - {{ $kelas->periode }}
                    </option>
                @endforeach
            </select>
            @error('id_kelas')
                <div class="text-danger">{{ $message }}</div>
            @enderror

            {{-- Input untuk Nama Siswa --}}
            <label for="nama">Nama Siswa :</label>
            <input type="text" id="nama" name="nama" value="{{ old('nama', $siswa->nama) }}" required>
            @error('nama')
                <div class="text-danger">{{ $message }}</div>
            @enderror

            {{-- Input untuk Tempat Lahir --}}
            <label for="tempat_lahir">Tempat Lahir :</label>
            <input type="text" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}" required>
            @error('tempat_lahir')
                <div class="text-danger">{{ $message }}</div>
            @enderror

            {{-- Input untuk Tanggal Lahir --}}
            <label for="tanggal_lahir">Tanggal Lahir :</label>
            <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}" required>
            @error('tanggal_lahir')
                <div class="text-danger">{{ $message }}</div>
            @enderror

            {{-- Tombol Submit dan Batal --}}
            <div class="button-container mt-3">
                <button id="submit_button" type="submit" class="btn btn-primary">
                    <i class="lni lni-save" style="vertical-align: middle; margin-right: 2px;"></i>
                    <span style="vertical-align: middle;">Ubah</span>
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
