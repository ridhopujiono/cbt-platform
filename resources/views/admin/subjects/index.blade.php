@extends('admin.layouts.app')

@section('title', 'Mata Pelajaran')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-content">

        @include('admin.layouts.breadcrumb.index')

        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5>Daftar Mata Pelajaran</h5>
                <a href="{{ route('admin.subjects.create') }}"
                   class="btn btn-primary btn-sm">
                    + Tambah Mapel
                </a>
            </div>

            <div class="card-body">

                <form class="mb-3">
                    <div class="input-group">
                        <input type="text"
                               name="keyword"
                               class="form-control"
                               placeholder="Cari mata pelajaran..."
                               value="{{ request('keyword') }}">
                        <div class="input-group-append">
                            <button class="btn btn-secondary">Cari</button>
                        </div>
                    </div>
                </form>

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="60">#</th>
                            <th>Nama</th>
                            <th width="180">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subjects as $subject)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $subject->name }}</td>
                                <td>
                                    <a href="{{ route('admin.subjects.edit', $subject) }}"
                                       class="btn btn-sm btn-warning">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.subjects.destroy', $subject) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Hapus mata pelajaran ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">
                                    Data kosong
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{ $subjects->links() }}
            </div>
        </div>

    </div>
</div>
@endsection
