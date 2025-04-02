@extends('app')

@section('content')

    <div class="login-container">
        <div class="form-box">
            <!-- Tambahkan gambar di sini -->
            <div class="text-center">
                <img src="{{ asset('images/logo.jpeg') }}"  alt="Logo SD IT JABAL NUR" class="img-fluid mb-4" style="max-width: 150px;">
            </div>

            <h1> SD IT JABAL NUR</h1>
            @if (session('success'))
                <p class="alert alert-success">{{ session('success') }}</p>
            @endif

            @if ($errors->any())
                @foreach ($errors->all() as $err)
                    <p class="alert alert-danger">{{ $err }}</p>
                @endforeach
            @endif

            <form action="{{ route('login.action') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="user" class="form-control" placeholder="Masukkan Username" value="{{ old('user') }}" required>
                </div>

                <div class="mb-3">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan Password" required>
                </div>

                <div class="mb-3 mt-4">
                    <button type="submit" class="btn-login">Log In </button>
                </div>
            </form>
        </div>
    </div>

@endsection
