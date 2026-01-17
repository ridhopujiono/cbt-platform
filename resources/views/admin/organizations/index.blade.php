@extends('admin.layouts.app')

@section('title', 'Organisasi')

@section('content')
<div class="pcoded-main-container">
<div class="pcoded-content">

@include('admin.layouts.breadcrumb.index')

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>Daftar Organisasi</h5>
        <a href="{{ route('admin.organizations.create') }}"
           class="btn btn-primary btn-sm">
            + Tambah Organisasi
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
                    <th>Nama</th>
                    <th>Tipe</th>
                    <th>Jumlah User</th>
                    <th width="120">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($organizations as $org)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $org->name }}</td>
                    <td>{{ $org->type ?? '-' }}</td>
                    <td>{{ $org->users()->count() }}</td>
                    <td>
                        <a href="{{ route('admin.organizations.edit', $org->id) }}"
                           class="btn btn-sm btn-outline-primary">
                            Edit
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">
                        Belum ada organisasi.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{ $organizations->links() }}
    </div>
</div>

</div>
</div>
@endsection
