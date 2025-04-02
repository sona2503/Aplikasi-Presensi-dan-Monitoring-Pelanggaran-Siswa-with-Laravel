@extends('sidebarguru')
@section('content')
    <div class="container">
        <div class="row mt-5">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
            <div class="col-8">
                <a href="javascript:history.back()" class="btn btn-secondary ml-2"><i class="lni lni-reply"></i> Back</a>
            </div>
        </div>
        <div class="container">
            <h1 class="text-center mt-5 mb-4">Edit Presensi Kelas {{ $kelas->kelas }} Tanggal {{ \Carbon\Carbon::parse($tanggal)->format('d M Y') }}</h1>
            <form action="{{ route('UpdatePresensiAction') }}" method="POST">
    @csrf
    @method('PUT')
    <input type="hidden" name="tanggal" value="{{ $tanggal }}">
    <input type="hidden" name="kelas_id" value="{{ $kelas->id_kelas }}">

    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">NISN</th>
                <th scope="col">Nama</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody>
        @foreach($presensi as $pres)
            <tr>
                <td>{{ $pres->nisn }}</td>
                <td>{{ $pres->nama }}</td>
                <td>
                    <!-- Tambahkan name yang sesuai -->
                    <select name="status[{{ $pres->nisn }}]" class="form-control">
                        <option value="Alpa" {{ $pres->status == 'Alpa' ? 'selected' : '' }}>Alpa</option>
                        <option value="Hadir" {{ $pres->status == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                        <option value="Sakit" {{ $pres->status == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                        <option value="Izin" {{ $pres->status == 'Izin' ? 'selected' : '' }}>Izin</option>
                    </select>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <button type="submit" class="btn btn-primary"><i class="lni lni-save"></i> Simpan</button>
</form>

        </div>
    </div>
@endsection
