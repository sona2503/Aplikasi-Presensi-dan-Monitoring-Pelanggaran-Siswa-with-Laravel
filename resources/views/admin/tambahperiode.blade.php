@extends('sidebaradmin')

@section('content')
    <div class="form-container mt-4">
        <h1>Tambah Periode</h1>

        {{-- Form yang mengarah ke route TambahPeriodeAction --}}
        <form action="{{ route('TambahPeriodeAction') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Input untuk Periode --}}
            <label for="periode">Tahun Ajaran :</label>
            <input type="text" id="periode" name="periode" value="{{ old('periode') }}" required>
            @error('periode')
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
