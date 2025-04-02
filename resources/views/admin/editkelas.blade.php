@extends('sidebaradmin')

@section('content')
    <div class="form-container mt-4">
        <h1>Edit Kelas</h1>

        {{-- Form untuk mengupdate data kelas --}}
        <form action="{{ route('UpdateKelasAction') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <input type="hidden" name="id_kelas" value="{{ $kelas->id_kelas }}">

            {{-- Dropdown untuk memilih Periode --}}
            <label for="id_periode">Pilih Periode :</label>
            <select id="id_periode" name="id_periode" required>
                @foreach($periode as $p)
                    <option value="{{ $p->id_periode }}" {{ $p->id_periode == $kelas->id_periode ? 'selected' : '' }}>
                        {{ $p->periode }}
                    </option>
                @endforeach
            </select>
            @error('id_periode')
                <div class="text-danger">{{ $message }}</div>
            @enderror

            {{-- Input untuk Nama Kelas --}}
            <label for="kelas">Nama Kelas :</label>
            <input type="text" id="kelas" name="kelas" value="{{ old('kelas', $kelas->kelas) }}" required>
            @error('kelas')
                <div class="text-danger">{{ $message }}</div>
            @enderror

            {{-- Tombol Submit dan Batal --}}
            <div class="button-container mt-3">
                <button id="submit_button" type="submit" class="btn btn-primary">
                    <i class="lni lni-pencil-alt"></i>
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
