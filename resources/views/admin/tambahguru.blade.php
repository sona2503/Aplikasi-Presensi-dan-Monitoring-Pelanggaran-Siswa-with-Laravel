@extends('sidebaradmin')

@section('content')
    <div class="form-container mt-4">
        <h1>Tambah Guru</h1>

        {{-- Form yang mengarah ke route TambahGuruAction --}}
        <form action="{{ route('TambahGuruAction') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Input untuk Nip --}}
            <label for="nip">NIP :</label>
            <input type="text" id="nip" name="nip" value="{{ old('nip') }}" required>
            @error('nip')
                <div class="text-danger">{{ $message }}</div>
            @enderror

            {{-- Dropdown untuk memilih Kelas --}}
            <label for="id_kelas">Pilih Kelas :</label>
            <select id="id_kelas" name="id_kelas" required>
                <option value="" disabled selected>Pilih Kelas</option>
                @foreach($select as $kelas)  {{-- Mengambil data kelas dari controller --}}
                    <option value="{{ $kelas->id_kelas }}" {{ old('id_kelas') == $kelas->id_kelas ? 'selected' : '' }}>
                        {{ $kelas->kelas }} - {{ $kelas->periode}}
                    </option>
                @endforeach
            </select>
            @error('id_kelas')
                <div class="text-danger">{{ $message }}</div>
            @enderror

            {{-- Input untuk Nama Guru --}}
            <label for="nama_guru">Nama Guru :</label>
            <input type="text" id="nama_guru" name="nama_guru" value="{{ old('nama_guru') }}" required>
            @error('nama_guru')
                <div class="text-danger">{{ $message }}</div>
            @enderror

            {{-- Input untuk No Telepon --}}
            <label for="no_telp">No Telepon :</label>
            <input type="text" id="no_telp" name="no_telp" value="{{ old('no_telp') }}" required>
            @error('no_telp')
                <div class="text-danger">{{ $message }}</div>
            @enderror

            {{-- Input untuk Alamat --}}
            <label for="alamat">Alamat :</label>
            <input type="text" id="alamat" name="alamat" value="{{ old('alamat') }}" required>
            @error('alamat')
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
