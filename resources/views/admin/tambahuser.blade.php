@extends('sidebaradmin')

@section('content')
    <div class="form-container mt-4">
        <h1>Tambah User</h1>

        {{-- Form yang mengarah ke route register.action --}}
        <form action="{{ route('register.action') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label>Role <span class="text-danger">*</span></label>
                <select class="form-control" name="id_role" id="roleSelect" onchange="toggleFields()">
                    <option value="">Pilih Role</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id_role }}">{{ $role->role }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3" id="nisnField" style="display:none;">
                <label>NISN <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="nisn" value="{{ old('nisn') }}" />
            </div>
            
            <div class="mb-3" id="nipField" style="display:none;">
                <label>NIP <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="nip" value="{{ old('nip') }}" />
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

    function toggleFields() {
        const roleSelect = document.getElementById('roleSelect');
        const nisnField = document.getElementById('nisnField');
        const nipField = document.getElementById('nipField');

        // Reset visibility
        nisnField.style.display = 'none';
        nipField.style.display = 'none';

        // Check selected role
        const selectedRole = roleSelect.options[roleSelect.selectedIndex].text;

        if (selectedRole === 'Ortu') {
            nisnField.style.display = 'block';
        } else if (selectedRole === 'Guru') {
            nipField.style.display = 'block';
        }
    }
</script>
