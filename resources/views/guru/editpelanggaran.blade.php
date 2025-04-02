@extends('sidebarguru')

@section('content')
    <div class="form-container mt-4">
        <h1>Edit Pelanggaran {{ $siswa->nama }}</h1>
        
        <form action="{{ route('UpdatePelanggaranAction') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Input ID Pelanggaran (Hidden) --}}
            <input type="hidden" name="id_pelanggaran" value="{{ $pelanggaran->id_pelanggaran ?? '' }}">
            
            {{-- Input NISN (Disabled) --}}
            <label for="nisn">NISN :</label>
            <input type="text" id="nisn" name="nisn" value="{{ $siswa->nisn }}" disabled>
            <input type="hidden" name="nisn" value="{{ $siswa->nisn }}">
            @error('nisn')
                <div class="text-danger">{{ $message }}</div>
            @enderror

            {{-- Input Tanggal Pelanggaran --}}
            <label for="waktu">Tanggal Pelanggaran :</label>
            <input type="date" id="waktu" name="waktu" value="{{ old('waktu', $pelanggaran->waktu ?? '') }}" required>
            @error('waktu')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            <label for="jenis_pelanggaran">Pelanggaran :</label>
             <select id="jenis_pelanggaran" name="jenis_pelanggaran" class="form-control" required>
                <option value="">-- Pilih Pelanggaran --</option>
                @foreach($select as $option)
                <option value="{{ $option->id_jenis }}" {{ $option->id_jenis == $pelanggaran->id_jenis ? 'selected' : '' }}>
                    {{ $option->pelanggaran }} -- {{ $option->jenis }} (Point: {{ $option->point }})
                </option>
                @endforeach
            </select>


            {{-- Input Catatan Pelanggaran --}}
            <label for="catatan">Catatan Pelanggaran :</label>
            <textarea id="catatan" name="catatan" rows="4" class="form-control" required>{{ old('catatan', $pelanggaran->catatan ?? '') }}</textarea>
            @error('catatan')
                <div class="text-danger">{{ $message }}</div>
            @enderror

    <!-- Foto Pelanggaran Saat Ini -->
    <label>Foto Saat Ini:</label><br>
    <img src="{{ asset('storage/'.$pelanggaran->path) }}" alt="Foto Pelanggaran" width="350"><br>

    <!-- Ganti Foto -->
    <label>Ganti Foto:</label>
    <input type="file" name="foto">

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
