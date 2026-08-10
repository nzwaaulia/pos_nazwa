@extends('layouts.app')

@section('title', 'Manajemen User - Nazwa Bakery')

@section('content')

@include('layouts.navbar')

<style>
    body {
        background: #fdfbf7 !important; /* Warm Cream Background */
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
    }
    .page-wrapper {
        padding: 40px 0;
    }

    /* HERO */
    .hero-user {
        background: linear-gradient(135deg, #4a3525 0%, #6f4e37 100%); /* Rich Mocha Gradient */
        border-radius: 24px;
        padding: 35px;
        color: white;
        box-shadow: 0 15px 35px rgba(74, 53, 37, 0.15);
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(212, 163, 115, 0.2);
    }
    .hero-user::before {
        content: '👥';
        position: absolute;
        top: -10px;
        right: 20px;
        font-size: 8rem;
        opacity: 0.08;
    }

    /* CARD */
    .custom-card {
        background: #ffffff;
        border: 1px solid #f0eae1;
        border-radius: 24px;
        box-shadow: 0 8px 25px rgba(74, 53, 37, 0.03);
        overflow: hidden;
    }

    /* BUTTON TAMBAH */
    .btn-create {
        background: white;
        color: #4a3525;
        border-radius: 12px;
        padding: 10px 22px;
        font-weight: 700;
        transition: .3s;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        text-decoration: none;
        display: inline-block;
    }
    .btn-create:hover {
        background: #f7f4ef;
        color: #3d2c1f;
        transform: translateY(-2px);
    }

    /* SEARCH */
    .search-box {
        border: 1px solid #e2d9cc;
        border-radius: 16px;
        padding: 6px;
        background-color: #fdfbf7;
    }
    .search-box input {
        border: none;
        height: 40px;
        background: transparent;
    }
    .search-box input:focus {
        box-shadow: none;
        background: transparent;
    }
    .search-btn {
        background: linear-gradient(135deg, #4a3525 0%, #6f4e37 100%);
        color: white;
        border-radius: 12px;
        padding: 0 22px;
        border: none;
        font-weight: 600;
        transition: .3s;
    }
    .search-btn:hover {
        background: linear-gradient(135deg, #3d2c1f 0%, #5c4d3c 100%);
        color: white;
    }

    /* TABLE */
    .table thead {
        background: #f7f4ef;
        color: #6f4e37;
    }
    .table thead th {
        padding: 16px;
        font-size: 12px;
        text-transform: uppercase;
        border: none;
        letter-spacing: 0.8px;
        font-weight: 600;
    }
    .table tbody tr {
        transition: .3s;
    }
    .table tbody tr:hover {
        background: #fdfbf7;
    }
    .table tbody td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #f4f1ea;
    }

    /* ROLE BADGES */
    .role {
        padding: 6px 14px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 600;
    }
    .role-admin {
        background: linear-gradient(135deg, #d4a373 0%, #bc6c25 100%);
        color: white;
    }
    .role-kasir {
        background: linear-gradient(135deg, #606c38 0%, #283618 100%);
        color: white;
    }
    .role-user {
        background: linear-gradient(135deg, #8c6d53 0%, #b08968 100%);
        color: white;
    }

    /* BUTTON AKSI */
    .btn-action {
        border: none;
        border-radius: 10px;
        padding: 6px 14px;
        font-weight: 600;
        transition: .3s;
        text-decoration: none;
        display: inline-block;
        font-size: 0.8rem;
    }
    .btn-edit {
        background: #f4e8dc;
        color: #6f4e37;
    }
    .btn-delete {
        background: #faedec;
        color: #bc4749;
    }
    .btn-action:hover {
        transform: translateY(-2px);
        opacity: 0.85;
    }

    /* PAGINATION */
    .pagination {
        justify-content: center;
    }
    .pagination .page-link {
        border: none;
        border-radius: 10px;
        margin: 3px;
        color: #6f4e37;
        background-color: #f7f4ef;
    }
    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #4a3525 0%, #6f4e37 100%);
        border-color: transparent;
        color: white;
    }
</style>

<div class="page-wrapper">
    <div class="container-fluid px-4">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert" style="background-color: #d1e7dd; color: #0f5132;">
                <div class="d-flex align-items-center">
                    <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                    <div>{{ session('success') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert" style="background-color: #f8d7da; color: #842029;">
                <div class="d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                    <div>{{ session('error') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="hero-user mb-4">
            <div class="position-relative">
                <span class="badge bg-white text-dark px-3 py-1 rounded-pill fw-bold mb-2 shadow-sm" style="color: #4a3525 !important;">
                    🥐 Mini Bites Bakery
                </span>
                <h1 class="fw-bold mb-2" style="font-family: serif;">
                    Kelola Karyawan & Akun
                </h1>
                <p class="mb-3 text-white-50">
                    Atur akses akun, role kasir, dan admin dengan aman dan terstruktur.
                </p>
                <a href="{{ route('admin.users.create') }}" class="btn btn-create">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Akun Baru
                </a>
            </div>
        </div>

        <div class="custom-card">
            
            <div class="p-4">
                <form action="{{ route('admin.users') }}" method="GET">
                    <div class="search-box d-flex align-items-center">
                        <i class="bi bi-search text-muted ms-3"></i>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control ms-2" placeholder="Cari nama atau email user...">
                        <button class="btn search-btn">
                            Cari
                        </button>
                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td class="ps-4 fw-bold text-muted">
                                {{ $users->firstItem() + $loop->index }}
                            </td>
                            <td>
                                <i class="bi bi-person-circle text-muted me-2"></i>
                                <strong class="text-dark">
                                    {{ $user->name }}
                                </strong>
                            </td>
                            <td class="text-muted">
                                {{ $user->email }}
                            </td>
                            <td>
                                @if(strtolower($user->role->name) == 'admin')
                                    <span class="role role-admin">
                                        {{ $user->role->name }}
                                    </span>
                                @elseif(strtolower($user->role->name) == 'kasir')
                                    <span class="role role-kasir">
                                        {{ $user->role->name }}
                                    </span>
                                @else
                                    <span class="role role-user">
                                        {{ $user->role->name }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn-action btn-edit">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn-action btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus user {{ $user->name }}?')">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <h5 class="text-muted">
                                    👤 Data akun tidak ditemukan 🥐
                                </h5>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4">
                {{ $users->links() }}
            </div>

        </div>

    </div>
</div>

@endsection