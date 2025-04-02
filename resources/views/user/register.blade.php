@extends('app')
@section('content')
<div class="row">
    <div class="col-md-6">
        @if($errors->any())
        @foreach($errors->all() as $err)
        <p class="alert alert-danger">{{ $err }}</p>
        @endforeach
        @endif
        <form action="{{ route('register.action') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>NISN <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="nisn" value="{{ old('nisn') }}" />
            </div>
            <div class="mb-3">
                <label>NIP <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="nip" value="{{ old('nip') }}" />
            </div>
            <div class="mb-3">
                <label>Id Role <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="id_role" value="{{ old('id_role') }}" />
            </div>
            <div class="mb-3">
                <label>Username <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="user" value="{{ old('user') }}" />
            </div>
            <div class="mb-3">
                <label>Password <span class="text-danger">*</span></label>
                <input class="form-control" type="password" name="password" />
            </div>
            <div class="mb-3">
                <label>Password Confirmation <span class="text-danger">*</span></label>
                <input class="form-control" type="password" name="password_confirm" />
            </div>
            <div class="mb-3">
                <button class="btn btn-primary">Register</button>
                <a class="btn btn-danger" href="">Back</a>
            </div>
        </form>
    </div>
</div>
@endsection
