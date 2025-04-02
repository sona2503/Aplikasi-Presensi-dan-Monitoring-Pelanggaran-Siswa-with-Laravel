@extends('sidebaradmin')

@section('content')
    <div class="form-container mt-4">
        <h1>Tambah Kelas</h1>

        {{-- Form yang mengarah ke route TambahKelasAction --}}
        <form action="{{ route('TambahKelasAction') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Dropdown untuk memilih Periode --}}
            <label for="id_periode">Pilih Periode :</label>
            <select id="id_periode" name="id_periode" required>
                <option value="" disabled selected>Pilih Periode</option>
                @foreach($select as $periode)  {{-- Mengambil data periode dari controller --}}
                    <option value="{{ $periode->id_periode }}" {{ old('id_periode') == $periode->id_periode ? 'selected' : '' }}>
                        {{ $periode->periode }}
                    </option>
                @endforeach
            </select>
            @error('id_periode')
                <div class="text-danger">{{ $message }}</div>
            @enderror

            {{-- Input untuk Nama Kelas --}}
            <label for="kelas">Nama Kelas :</label>
            <input type="text" id="kelas" name="kelas" value="{{ old('kelas') }}" required>
            @error('kelas')
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
