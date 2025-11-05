@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Header con título y botón -->
    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class=" fw-bold mb-0">GESTIÓN DE PLANES</h4>
            
        </div>
        <a href="{{ route('plans.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg fw-bold"> Nuevo Plan</i>
        </a>
    </div>
    @include('messages.alert')
    <!-- Tabla de planes -->
    <div>
        <div>
            @if($plans->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Precio</th>
                            <th>Límite de Usuarios</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($plans as $plan)
                        <tr>
                            <td><strong>{{ $plan->id }}</strong></td>
                            <td>{{ $plan->name }}</td>
                            <td>{{ Str::limit($plan->description, 50) }}</td>
                            <td>
                                <span class="badge bg-success">${{ number_format($plan->price, 2) }}</span>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $plan->limit_users }} usuarios</span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <!-- Botón de editar -->
                                    <a href="{{ route('plans.edit', $plan->id) }}" 
                                       class="btn btn-action btn-edit"
                                       title="Editar plan">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <!-- Botón de eliminar -->
                                    {{--<button class="btn btn-danger btn-sm delete-plan" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deletePlanModal"
                                            data-id="{{ $plan->id }}"
                                            data-name="{{ $plan->name }}"
                                            title="Eliminar plan">
                                        <i class="bi bi-trash-fill"></i>
                                    </button> --}}
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @else
            <div class="text-center py-5">
                <i class="bi bi-inbox display-1 text-muted"></i>
                <h4 class="text-muted mt-3">No hay planes registrados</h4>
                <p class="text-muted">Comienza creando tu primer plan.</p>
                <a href="{{ route('plans.create') }}" class="btn btn-primary mt-3">
                    <i class="bi bi-plus-circle"></i> Crear Primer Plan
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    .table th {
        border-top: none;
        font-weight: 600;
    }
    
    .btn-group .btn {
        margin-right: 8px;
    }
    
    .table-responsive {
        border-radius: 0.375rem;
    }

    
        .btn-group-options {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-action {
        padding: 8px 12px;
        border: none;
        background: #cbcacaff;
        color: #495057;
        font-size: 14px;
        transition: all 0.2s ease;
    }

    .btn-action:not(:last-child) {
        border-right: 1px solid #dee2e6;
    }

    .btn-action:hover {
        transform: translateY(-1px);
        color: #fff;
    }

    .btn-edit:hover { background: #ffc107; }
    .btn-info:hover { background: #17a2b8; }
    .btn-branches:hover { background: #28a745; }
    .btn-admins:hover { background: #6f42c1; }

    .btn-action i {
        transition: transform 0.2s ease;
    }

    .btn-action:hover i {
        transform: scale(1.1);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .btn-group-options {
            display: flex;
            flex-direction: column;
        }
        
        .btn-action:not(:last-child) {
            border-right: none;
            border-bottom: 1px solid #dee2e6;
        }
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection