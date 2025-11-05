@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Encabezado -->
    <div class="container-fluid mb-4">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('subscriptions.admins', $tenant->id) }}">
                <i class="bi bi-arrow-left fs-4"></i>
            </a>
            <div>
                <h4 class="mb-1 fw-bold">
                    EDITAR ADMINISTRADOR - {{ $admin->name }}
                </h4>
                <p class="text-muted mb-0">{{ $tenant->company_name }}</p>
            </div>
        </div>
    </div>

    <!-- Formulario de edición -->
    <div class="container-fluid">
            <div class="card-body">
                <form action="{{ route('subscriptions.admin.update', ['id' => $tenant->id, 'admin' => $admin->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Nombre <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $admin->name) }}" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label">Usuario <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('username') is-invalid @enderror" 
                                   id="username" 
                                   name="username" 
                                   value="{{ old('username', $admin->username) }}" 
                                   required>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', $admin->email) }}" 
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="old_password" class="form-label">Contraseña Actual</label>
                            <input type="text" 
                                   class="form-control @error('old_password') is-invalid @enderror" 
                                   id="old_password" 
                                   name="old_password" 
                                   value="{{ $admin->nickname }}"
                                   disabled>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">Nueva Contraseña</label>
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   placeholder="Dejar en blanco para mantener la actual">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                            <input type="password" 
                                   class="form-control" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   placeholder="Confirmar nueva contraseña">
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('subscriptions.admins', $tenant->id) }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-1"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i> Actualizar
                        </button>
                    </div>
                </form>
            </div>
        
    </div>
</div>
<style>
    .form-label {
        font-weight: 700 !important;
        margin-bottom: 0.5rem;
    }
</style>
@endsection