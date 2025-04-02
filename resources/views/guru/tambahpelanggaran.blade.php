@extends('sidebarguru')

@section('content')
    <div class="form-container mt-4">
        <h1>Catat Pelanggaran {{ $siswa->nama }}</h1>
        
        {{-- Form yang mengarah ke route TambahPelanggaranAction --}}
        <form action="{{ route('TambahPelanggaranAction') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Input NISN (Disabled) --}}
            <label for="nisn">NISN :</label>
            <input type="text" id="nisn" name="nisn" value="{{ old('nisn', $nisn) }}" disabled>
            <input type="hidden" name="nisn" value="{{ old('nisn', $nisn) }}">
            @error('nisn')
                <div class="text-danger">{{ $message }}</div>
            @enderror

            {{-- Input Tanggal Pelanggaran --}}
            <label for="waktu">Tanggal Pelanggaran :</label>
            <input type="date" id="waktu" name="waktu" value="{{ old('waktu') }}" required>
            @error('waktu')
                <div class="text-danger">{{ $message }}</div>
            @enderror

            {{-- Dropdown Jenis Pelanggaran --}}
            <label for="jenis_pelanggaran">Pelanggaran :</label>
            <select id="jenis_pelanggaran" name="jenis_pelanggaran" class="form-control" required>
                <option value="">-- Pilih Pelanggaran --</option>
                @foreach($select as $pelanggaran)
                    <option value="{{ $pelanggaran->id_jenis }}">
                        {{ $pelanggaran->pelanggaran }} -- {{ $pelanggaran->jenis }} (Point: {{ $pelanggaran->point }})
                    </option>
                @endforeach
            </select>
            @error('jenis_pelanggaran')
                <div class="text-danger">{{ $message }}</div>
            @enderror

            {{-- Input Catatan Pelanggaran --}}
            <label for="catatan">Catatan Pelanggaran :</label>
            <textarea id="catatan" name="catatan" rows="4" class="form-control" required>{{ old('catatan') }}</textarea>
            @error('catatan')
                <div class="text-danger">{{ $message }}</div>
            @enderror

            {{-- Input Upload Foto --}}
            <label for="foto">Unggah Foto Bukti :</label>
            <input type="file" id="foto" name="foto" accept="image/*" class="form-control">
            @error('foto')
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
