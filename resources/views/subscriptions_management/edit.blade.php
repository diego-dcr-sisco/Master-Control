@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Encabezado de la página -->
    <div class="mb-4">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('subscriptions.index') }}" class="col-auto btn-primary p-0 fs-3">
                        <i class="bi bi-arrow-left fs-4"></i>
                    </a>
                    <h4 class="mb-2 fw-bold">
                        EDITAR SUSCRIPCIÓN
                    </h4>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <!-- Información de la suscripción -->
        <div class="subscription-status">
            <div>
                <h6 class=" fw-bold">ID: {{ $tenant->id }}</h6>
                <span class="text-muted">Creado: {{ $tenant->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <div class="text-end">
                <span class="badge {{ $tenant->is_active ? 'bg-success' : 'bg-secondary' }}" id="statusBadge">
                    {{ $tenant->is_active ? 'Activo' : 'Inactivo' }}
                </span>
                <div class="mt-1">
                    @php
                        $daysLeft = intval(now()->diffInDays($tenant->subscription_end, false));
                    @endphp
                    <small class="text-muted" id="daysLeftInfo">
                        {{ $daysLeft > 0 ? $daysLeft . ' días restantes' : 'Expirada' }}
                    </small>
                </div>
            </div>
        </div>

        <form id="editTenantForm" action="{{ route('subscriptions.update', $tenant->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <!-- Información de la Empresa -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="bi bi-building me-2"></i>Información de la Empresa
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="company_name" class="form-label fw-semibold">Nombre de la Empresa</label>
                                <input type="text" class="form-control" id="company_name" name="company_name" 
                                       value="{{ $tenant->company_name }}" required>
                                @error('company_name')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="slug" class="form-label fw-semibold">Slug</label>
                                <input type="text" class="form-control" id="slug" name="slug" 
                                       value="{{ $tenant->slug }}" disabled>
                                @error('slug')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Detalles de la Suscripción -->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="bi bi-card-checklist me-2"></i>Detalles de la Suscripción
                                </h5>
                            </div>
                            <div class="card-body">
                                <!-- Fila para Plan y Límite de Usuarios -->
                                <div class="row">
                                    <div class="col-md-8 mb-3">
                                        <label for="plan_id" class="form-label fw-semibold">Tipo de Plan</label>
                                        <select class="form-select" id="plan_id" name="plan_id" required>
                                            <option value="">Seleccionar Plan</option>
                                            @foreach($plans as $plan)
                                                <option value="{{ $plan->id }}" data-limit-users="{{ $plan->limit_users }}"
                                                        {{ $tenant->plan_id == $plan->id ? 'selected' : '' }}>
                                                    {{ $plan->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('plan_id')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="limit_users" class="form-label">Límite de Usuarios *</label>
                                        <input type="number" 
                                            class="form-control @error('limit_users') is-invalid @enderror" 
                                            id="limit_users" 
                                            name="limit_users" 
                                            value="{{ old('limit_users') }}" 
                                            disabled
                                            placeholder="Seleccione un plan">
                                            
                                        @error('limit_users')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <!-- Estado de la suscripción  -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Estado de la suscripción</label>
                                    <select name="status_select" class="form-select" id="status_select">
                                        <option value="true" {{ isset($tenant) && $tenant->is_active ? 'selected' : (old('status_select', 'true') == 'true' ? 'selected' : '') }}>Activo</option>
                                        <option value="false" {{ isset($tenant) && !$tenant->is_active ? 'selected' : (old('status_select', 'true') == 'false' ? 'selected' : '') }}>Inactivo</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>

            <!-- Fechas de Suscripción -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-calendar-range me-2"></i>Fechas de Suscripción
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="subscription_start" class="form-label fw-semibold">Fecha de Inicio</label>
                                <input type="date" class="form-control" id="subscription_start" name="subscription_start" 
                                       value="{{ $tenant->subscription_start ? $tenant->subscription_start->format('Y-m-d') : '' }}">
                                @error('subscription_start')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="subscription_end" class="form-label fw-semibold">Fecha de Fin</label>
                                <input type="date" class="form-control" id="subscription_end" name="subscription_end" 
                                       value="{{ $tenant->subscription_end ? $tenant->subscription_end->format('Y-m-d') : '' }}">
                                @error('subscription_end')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <!-- Botón de eliminar -->
                                 <label for="delete" class="form-label fw-semibold">Eliminar Suscripción</label>
                                <a href="{{ route('subscriptions.destroy', ['id' => $tenant->id]) }}"
                                    onclick="return confirm('Al eliminar se perderá toda la información relacionada con este suscriptor ¿Estás seguro de eliminar este suscriptor?');"
                                    class="btn btn-danger btn-sm"  title="Eliminar suscriptor">
                                    <i class="bi bi-trash-fill"></i>
                                </a>               
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-info">
                        <small>
                            <i class="bi bi-info-circle me-2"></i>
                            La suscripción se marcará como "Inactiva" automáticamente cuando la fecha de fin sea anterior a la fecha actual.
                        </small>
                    </div>
                </div>
            </div>

            <!-- Botones de acción -->
                <div>
                    <div class="d-flex justify-content-end align-items-center gap-2">
                        <a href="{{ route('subscriptions.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-1"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i> Guardar Cambios
                        </button>
                    </div>
                </div>
            
        </form>
    </div>
</div>
@endsection

<style>
    
    .card {
        border: none;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-bottom: 1.5rem;
        border-radius: 10px;
    }
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
        padding: 1rem 1.5rem;
        border-radius: 10px 10px 0 0 !important;
    }
    .subscription-status {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        background-color: #d1d5daff;
        border-radius: 8px;
        margin-bottom: 1.5rem;
    }
    .btn-back {
        background-color: rgba(255, 255, 255, 0.2);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }
    .btn-back:hover {
        background-color: rgba(255, 255, 255, 0.3);
        color: white;
    }
    .form-label {
        font-weight: 600;
        color: #495057;
    }
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const planSelect = document.getElementById('plan_id');
    const limitUsersInput = document.getElementById('limit_users');
    
    // Función para actualizar el límite de usuarios
    function updateUserLimit() {
        const selectedOption = planSelect.options[planSelect.selectedIndex];
        const limitUsers = selectedOption.getAttribute('data-limit-users');
        
        if (limitUsers) {
            limitUsersInput.value = limitUsers;
        } else {
            limitUsersInput.value = '';
        }
    }

    updateUserLimit();
    
    planSelect.addEventListener('change', updateUserLimit);
});
</script>



<script>
document.addEventListener('DOMContentLoaded', function() {
    const startDateInput = document.getElementById('subscription_start');
    const endDateInput = document.getElementById('subscription_end');
    const statusBadge = document.getElementById('statusBadge');
    const daysLeftInfo = document.getElementById('daysLeftInfo');
    const isActiveCheckbox = document.getElementById('is_active');
    
    // Validación de fechas en tiempo real
    if (startDateInput && endDateInput) {
        startDateInput.addEventListener('change', function() {
            if (this.value && endDateInput.value && this.value > endDateInput.value) {
                endDateInput.value = this.value;
            }
            endDateInput.min = this.value;
        });
        
        endDateInput.addEventListener('change', function() {
            if (this.value && startDateInput.value && this.value < startDateInput.value) {
                this.value = startDateInput.value;
            }
        });
    }
    
    // Validación del formulario
    document.getElementById('editTenantForm').addEventListener('submit', function(e) {
        const startDate = startDateInput.value;
        const endDate = endDateInput.value;
        
        if (startDate && endDate && startDate > endDate) {
            e.preventDefault();
            alert('La fecha de fin no puede ser anterior a la fecha de inicio.');
            endDateInput.focus();
            return false;
        }
        
        // Mostrar confirmación antes de enviar
        if (!confirm('¿Estás seguro de que deseas guardar los cambios?')) {
            e.preventDefault();
            return false;
        }
        
        return true;
    });
    
});
</script>
