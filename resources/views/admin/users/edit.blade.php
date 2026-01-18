@extends('admin.layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-content">

        @include('admin.layouts.breadcrumb.index')

        <div class="card">
            <div class="card-header">
                <h5>Edit User</h5>
            </div>

            <div class="card-body">
                @foreach ($errors->all() as $error)
                <div class="alert alert-danger">
                    {{ $error }}
                </div>
                @endforeach
                <form method="POST"
                    action="{{ route('admin.users.update', $user->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>Username</label>
                        <input type="text"
                            name="username"
                            class="form-control"
                            value="{{ $user->username }}"
                            required>
                    </div>

                    <div class="form-group">
                        <label>Password (Opsional)</label>
                        <input type="password"
                            name="password"
                            class="form-control"
                            placeholder="Kosongkan jika tidak diubah">
                    </div>

                    <div class="form-group">
                        <label>Role</label>
                        <select name="role" class="form-control" required>
                            <option value="student"
                                {{ $user->role === 'student' ? 'selected' : '' }}>
                                Siswa
                            </option>
                            <option value="admin"
                                {{ $user->role === 'admin' ? 'selected' : '' }}>
                                Admin
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Organisasi</label>
                        <select name="org_id" class="form-control">
                            <option value="">-- Tidak Ada --</option>
                            @foreach ($organizations as $org)
                            <option value="{{ $org->id }}"
                                {{ $user->org_id == $org->id ? 'selected' : '' }}>
                                {{ $org->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <button class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.users.index') }}"
                        class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection