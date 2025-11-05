@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('plans.index') }}">
            <i class="bi bi-arrow-left fs-4"></i>
        </a>
        <h4 class=" mb-0 fw-bold">CREAR NUEVO PLAN</h4>
    </div>

        <div class="card-body">
            <form action="{{ route('plans.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <!-- Nombre del Plan -->
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Nombre del Plan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" 
                               placeholder="Ej: Básico, Premium" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Precio -->
                    <div class="col-md-6 mb-3">
                        <label for="price" class="form-label">Precio <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                   id="price" name="price" step="0.01" min="0" 
                                   value="{{ old('price') }}" placeholder="0.00" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <small class="form-text text-muted">Precio mensual del plan</small>
                    </div>
                </div>

                <!-- Descripción -->
                <div class="mb-3">
                    <label for="description" class="form-label">Descripción</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="3" 
                              placeholder="Describe las características y beneficios del plan">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Límite de Usuarios -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="limit_users" class="form-label">Límite de Usuarios <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('limit_users') is-invalid @enderror" 
                               id="limit_users" name="limit_users" min="1" 
                               value="{{ old('limit_users') }}" 
                               placeholder="Número máximo de usuarios permitidos" required>
                        @error('limit_users')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Número máximo de usuarios en el plan</small>
                    </div>
                </div>

                <!-- Botones -->
                <div class="d-flex justify-content-end align-items-center gap-2 mt-4">
                    <a href="{{ route('plans.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle me-1"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-1"></i> Crear Plan
                    </button>
                </div>
            </form>
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

    // Formatear precio automáticamente
    const priceInput = document.getElementById('price');
    if (priceInput) {
        priceInput.addEventListener('blur', function() {
            if (this.value) {
                this.value = parseFloat(this.value).toFixed(2);
            }
        });
    }
});
</script>
@endsection