@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('plans.index') }}">
            <i class="bi bi-arrow-left fs-4"></i>
        </a>
        <h4 class="mb-0 fw-bold">EDITAR PLAN</h4>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('plans.update',  ['id' => $plan->id]) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <!-- ID  -->
                    <div class="col-md-2 mb-3">
                        <label for="id" class="form-label">ID</label>
                        <input type="text" class="form-control" id="id" name="id" 
                               value="{{ $plan->id }}" disabled>
                    </div>

                    <!-- Nombre -->
                    <div class="col-md-10 mb-3">
                        <label for="name" class="form-label">Nombre del Plan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $plan->name) }}" 
                               placeholder="Ingrese el nombre del plan" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Descripción -->
                <div class="mb-3">
                    <label for="description" class="form-label">Descripción</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="3" 
                              placeholder="Descripción del plan">{{ old('description', $plan->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <!-- Precio -->
                    <div class="col-md-6 mb-3">
                        <label for="price" class="form-label">Precio <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                   id="price" name="price" step="0.01" min="0" 
                                   value="{{ old('price', $plan->price) }}" 
                                   placeholder="0.00" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Límite de Usuarios -->
                    <div class="col-md-6 mb-3">
                        <label for="limit_users" class="form-label">Límite de Usuarios <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('limit_users') is-invalid @enderror" 
                               id="limit_users" name="limit_users" min="1" 
                               value="{{ old('limit_users', $plan->limit_users) }}" 
                               placeholder="Número máximo de usuarios" required>
                        @error('limit_users')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Botones -->
                <div class="d-flex justify-content-end align-items-center gap-2">
                    <a href="{{ route('plans.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Actualizar Plan
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validación del formulario
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const price = document.getElementById('price').value;
        const limitUsers = document.getElementById('limit_users').value;
        
        if (price < 0) {
            e.preventDefault();
            alert('El precio no puede ser negativo');
            return false;
        }
        
        if (limitUsers < 1) {
            e.preventDefault();
            alert('El límite de usuarios debe ser al menos 1');
            return false;
        }
    });
});
</script>
@endsection