@extends('sidebarguru')

@section('content')
    <div class="container mt-4">
        <div class="col">
        <a href="javascript:history.back()" class="btn btn-secondary ml-2"><i class="lni lni-reply"></i> Back</a>
        </div>
        <h1 class="text-center mt-5 mb-4" >Detail Pelanggaran Siswa</h1>
    <div class="container">
        <div class="col">
        <div class="card">
  <div class="card-body">
    <h5 class="card-title">Catatan</h5>
    @foreach($data as $pelanggaran)
    <p class="card-text">{{ $pelanggaran->catatan }}</p>
    <p class="card-text"><small class="text"> Point : {{ $pelanggaran->point }}</small></p>
  </div>
  <img src="{{ asset('storage/' . trim($pelanggaran->path)) }}" class="card-img-bottom" alt="Foto Bukti" >
  @endforeach
</div>
        </div>
    </div>
@endsection
