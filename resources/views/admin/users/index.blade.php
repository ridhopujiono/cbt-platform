@extends('admin.layouts.app')

@section('title', 'User')

@section('content')
<div class="pcoded-main-container">
<div class="pcoded-content">

@include('admin.layouts.breadcrumb.index')

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>Daftar User</h5>
        <a href="{{ route('admin.users.create') }}"
           class="btn btn-primary btn-sm">
            + Tambah User
        </a>
    </div>

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Organisasi</th>
                    <th width="120">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $u)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $u->username }}</td>
                    <td>
                        <span class="badge
                            {{ $u->role === 'admin' ? 'badge-danger' : 'badge-info' }}">
                            {{ strtoupper($u->role) }}
                        </span>
                    </td>
                    <td>{{ $u->organization->name ?? '-' }}</td>
                    <td>
                        <a href="{{ route('admin.users.edit', $u->id) }}"
                           class="btn btn-sm btn-outline-primary">
                            Edit
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $users->links() }}
    </div>
</div>

</div>
</div>
@endsection
