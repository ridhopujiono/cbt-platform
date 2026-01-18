@extends('admin.layouts.app')

@section('title', 'Tambah User')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-content">

        @include('admin.layouts.breadcrumb.index')

        <div class="card">
            <div class="card-header">
                <h5>Tambah User</h5>
            </div>

            <div class="card-body">
                @foreach ($errors->all() as $error)
                <div class="alert alert-danger">
                    {{ $error }}
                </div>
                @endforeach
                <form method="POST"
                    action="{{ route('admin.users.store') }}">
                    @csrf

                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text"
                            name="name"
                            class="form-control"
                            required>
                    </div>

                    <div class="form-group">
                        <label>Username</label>
                        <input type="text"
                            name="username"
                            class="form-control"
                            required>
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password"
                            name="password"
                            class="form-control"
                            required>
                    </div>

                    <div class="form-group">
                        <label>Role</label>
                        <select name="role" class="form-control" required>
                            <option value="student">Siswa</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Organisasi</label>
                        <select name="org_id" class="form-control">
                            <option value="">-- Tidak Ada --</option>
                            @foreach ($organizations as $org)
                            <option value="{{ $org->id }}">
                                {{ $org->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <button class="btn btn-primary">Simpan</button>
                    <a href="{{ route('admin.users.index') }}"
                        class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection