@extends('layouts.app')
@section('content')
<div class="container-fluid py-4">
    <!-- Encabezado de la página -->
    <div class="container-fluid mb-4">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('subscriptions.admins', $tenant->id) }}" >
                <i class="bi bi-arrow-left fs-4"></i>
            </a>
            <div>
                <h4 class="mb-1 fw-bold">
                    NUEVO ADMINISTRADOR - {{ $tenant->company_name }}
                </h4>
                <p class="text-muted mb-0">Complete la información para crear un nuevo administrador</p>
            </div>
        </div>
    </div>

    <!-- Formulario para crear administrador -->
    <div class="container-fluid">
            <div class="card-body">
                <form action="{{ route('subscriptions.adminStore', $tenant->id) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="admin_name" class="form-label">Nombre del Administrador <span class="text-danger">*</span></label>
                            <input type="text" 
                                class="form-control @error('admin_name') is-invalid @enderror" 
                                id="admin_name" 
                                name="admin_name" 
                                value="{{ old('admin_name') }}" 
                                required
                                placeholder="Nombre completo">
                            @error('admin_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label">Usuario del Administrador <span class="text-danger">*</span></label>
                            <input type="text" 
                                class="form-control @error('username') is-invalid @enderror" 
                                id="username" 
                                name="username" 
                                value="{{ old('username') }}" 
                                required
                                placeholder="Nombre de usuario">
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="admin_email" class="form-label">Email del Administrador <span class="text-danger">*</span></label>
                            <input type="email" 
                                class="form-control @error('admin_email') is-invalid @enderror" 
                                id="admin_email" 
                                name="admin_email" 
                                value="{{ old('admin_email') }}" 
                                required
                                placeholder="email@ejemplo.com">
                            @error('admin_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="admin_password" class="form-label">Contraseña <span class="text-danger">*</span></label>
                            <input type="password" 
                                class="form-control @error('admin_password') is-invalid @enderror" 
                                id="admin_password" 
                                name="admin_password" 
                                required
                                placeholder="Mínimo 8 caracteres">
                            @error('admin_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="admin_password_confirmation" class="form-label">Confirmar Contraseña <span class="text-danger">*</span></label>
                            <input type="password" 
                                class="form-control" 
                                id="admin_password_confirmation" 
                                name="admin_password_confirmation" 
                                required
                                placeholder="Reingrese la contraseña">
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('subscriptions.admins', $tenant->id) }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-1"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-person-plus me-1"></i> Crear Administrador
                        </button>
                    </div>
                </form>
            </div>
        
    </div>
</div>

<style>
    .card {
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border-radius: 0.5rem;
    }
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
        border-radius: 0.5rem 0.5rem 0 0 !important;
    }

    .form-label {
        font-weight: 700 !important;
        margin-bottom: 0.5rem;
    }

    .text-primary {
        color: #0d6efd !important;
    }

    .btn {
        border-radius: 0.375rem;
    }

    .input-group-text {
        background-color: #e9ecef;
        border: 1px solid #ced4da;
        color: #6c757d;
    }

    
    .form-control:required, .form-select:required {
        border-left: 3px solid #0d6efd;
    }

    .form-control:required:focus, .form-select:required:focus {
        border-left: 3px solid #0d6efd;
    }
</style>
@endsection