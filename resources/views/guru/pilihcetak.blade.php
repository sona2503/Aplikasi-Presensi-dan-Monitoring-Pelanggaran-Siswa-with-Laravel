@extends('sidebarguru')
@section('content')
    <div class="container">
        <div class="row mt-5">
            <div class="container">
                <h1 class="text-center mt-5 mb-4">Pilih untuk Mencetak</h1>
                <div class="col-4">
                </div><br>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">NISN</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Cetak</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($siswa as $item)
                            <tr>
                                <td>{{ $item->nisn }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>
                                    <a class="btn btn-success" href="{{ route('SeleksiCetak', ['nisn' => $item->nisn]) }}" role="button">
                                     <i class="lni lni-printer"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
