@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Encabezado de la página -->
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div class="d-flex align-items-center gap-3">
                <a href="{{route('subscriptions.index')}}" class="col-auto btn-primary p-0 fs-3">
                    <i class="bi bi-arrow-left fs-4"></i>
                </a>
                <div>
                    <h4 class="mb-2 fw-bold">
                        GESTIÓN DE USUARIOS ADMINISTRADORES DE - {{ $tenant->company_name }}
                    </h4>
                </div>
            </div>
            
            <!-- Contador -->
            <div class="text-end">
                <div class="card border-0 bg-light-subtle">
                    <div class="card-body py-2 px-3">
                        <h6 class="mb-0 text-muted">
                            <i class="bi bi-people me-1"></i>
                            {{ $admins->count() }} Administrador{{ $admins->count() !== 1 ? 'es' : '' }}
                        </h6>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botón agregar administrador -->
        <div class="mb-4">
            <a href="{{ route('subscriptions.adminsCreate', $tenant->id) }}" class="btn btn-primary fw-bold">
                <i class="bi bi-person-plus"></i> Agregar Administrador
            </a>
        </div>
    </div>

    <!-- Contenido de administradores -->
    <div class="container-fluid">
        @if($admins->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th class="fw-bold" scope="col">Usuario</th>
                                    <th class="fw-bold" scope="col">Información de Contacto</th>
                                    <th class="fw-bold" scope="col">Rol</th>
                                    <th class="fw-bold" scope="col">Estado</th>
                                    <th class="fw-bold" scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($admins as $admin)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm me-3">
                                                    <div class="avatar-title   text-black">
                                                         <i class="fas fa-user-cog"></i>
                                                    </div>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ $admin->name }}</h6>
                                                    <small class="text-muted">{{ $admin->username }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="mb-1">
                                                <i class="bi bi-envelope"></i> {{ $admin->email }}
                                            </p>
                                        </td>
                                        <td>
                                            {{ $admin->getRoleNames()->first() }}
                                        </td>
                                        <td>
                                            @if($admin->status_id==2)
                                                <span class="badge bg-success">
                                                    <i class="bi bi-check-circle"></i> Activo
                                                </span>
                                            @else
                                                <span class="badge bg-danger">
                                                    <i class="bi bi-x-circle"></i> Inactivo
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('subscriptions.admin.edit', ['id' => $tenant->id, 'admin' => $admin->id]) }}" 
                                                   class="btn btn-action btn-bk" title="Editar">
                                                <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                
            
        @else
            <!-- Estado vacío -->
            <div class="text-center py-5">
                <div class="empty-state">
                    <i class="bi bi-people fs-1 text-muted"></i>
                    <h3 class="mt-3">No hay administradores registrados</h3>
                    <p class="text-muted">Comienza agregando el primer administrador para esta empresa.</p>
                    <a href="{{ route('subscriptions.adminsCreate', $tenant->id) }}" class="btn btn-primary mt-3">
                        <i class="bi bi-person-plus"></i> Agregar Primer Administrador
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
    .avatar-sm {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }
    .table td {
        vertical-align: middle;
    }
    .empty-state {
        max-width: 400px;
        margin: 0 auto;
    }
    .card {
        transition: transform 0.2s ease-in-out;
    }
    .card:hover {
        transform: translateY(-2px);
    }
    /* contador */
    .bg-light-subtle {
        background-color: #f8f9fa !important;
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

    .btn-bk:hover { background: #ffc107; }

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