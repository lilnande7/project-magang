@extends('admin.layout')

@section('title', 'Edit Anggota')
@section('page-title', 'Edit Anggota')

@push('styles')
<style>
    :root {
        --ink: #06142b;
        --dusk: #1f3b73;
    }

    .card-holo {
        border-radius: 1.1rem;
        border: 1px solid rgba(6, 20, 43, 0.08);
        background: #ffffff;
        box-shadow: 0 30px 60px rgba(15, 36, 75, 0.1);
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-lg-10 mx-auto">
        @if ($errors->any())
            <div class="alert alert-danger shadow-sm border-0 rounded-4 mb-4">
                <strong>Terjadi kesalahan:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.users.update', $user) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.users.partials.form-fields', [
                'user' => $user,
                'roles' => $roles,
                'defaultRoleId' => null,
                'submitLabel' => 'Perbarui Anggota',
            ])
        </form>
    </div>
</div>
@endsection
