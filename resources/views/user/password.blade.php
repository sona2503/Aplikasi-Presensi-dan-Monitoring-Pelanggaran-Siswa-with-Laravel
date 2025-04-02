@extends('app')

@section('content')

    <div class="login-container">
        <div class="form-box">
            <h1>Ganti Password</h1>
            @if (session('success'))
                <p class="alert alert-success">{{ session('success') }}</p>
            @endif

            @if ($errors->any())
                @foreach ($errors->all() as $err)
                    <p class="alert alert-danger">{{ $err }}</p>
                @endforeach
            @endif

            <form action="{{ route('password.action') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="old_password">Password Lama</label>
                    <input type="password" id="old_password" name="old_password" class="form-control" placeholder="Isi Password Lama" required>
                </div>

                <div class="mb-3">
                    <label for="new_password">Password Baru</label>
                    <input type="password" id="new_password" name="new_password" class="form-control" placeholder="Isi Password Baru" required>
                </div>

                <div class="mb-3">
                    <label for="new_password_confirmation">Konfirmasi Password Baru</label>
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control" placeholder="Konfirmasi Password Baru" required>
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn-password">Ubah Password</button>
                </div>
            </form>
        </div>
    </div>

@endsection
