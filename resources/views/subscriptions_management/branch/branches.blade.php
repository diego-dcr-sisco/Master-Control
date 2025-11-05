@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Encabezado -->
    <div class="">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('subscriptions.index') }}" class="col-auto btn-primary p-0 fs-3">
                        <i class="bi bi-arrow-left fs-4"></i>
                    </a>
                    <h4 class="mb-2 fw-bold">
                        SUCURSALES - {{ $tenant->company_name }}
                    </h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido de sucursales -->
    <div class="container-fluid">
        @if($branches->count() > 0)
            <div class="row">
                @foreach($branches as $branch)
                    <div class="col-md-12 col-lg-12 mb-4">
                        <div class="card h-100 shadow-sm position-relative">
                            <!-- Encabezado  -->
                            <div class="card-header bg-light">
                                <h5 class="card-title mb-0 text-dark">
                                    <i class="bi bi-building me-2"></i> {{ $branch->name }}
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- Información de contacto -->
                                    <div class="col-md-3 mb-3">
                                        <h6 class="text-primary mb-3">Información de Contacto</h6>
                                        <p class="mb-2">
                                            <i class="bi bi-envelope me-2 text-muted"></i> 
                                            <span class="text-dark">{{ $branch->email ?? 'No especificado' }}</span>
                                        </p>
                                        <p class="mb-2">
                                            <i class="bi bi-telephone me-2 text-muted"></i> 
                                            <span class="text-dark">{{ $branch->phone ?? 'No especificado' }}</span>
                                        </p>
                                        @if($branch->alt_email)
                                        <p class="mb-2">
                                            <i class="bi bi-envelope-check me-2 text-muted"></i> 
                                            <span class="text-dark">{{ $branch->alt_email }}</span>
                                        </p>
                                        @endif
                                        @if($branch->alt_phone)
                                        <p class="mb-2">
                                            <i class="bi bi-telephone-plus me-2 text-muted"></i> 
                                            <span class="text-dark">{{ $branch->alt_phone }}</span>
                                        </p>
                                        @endif
                                        @if($branch->url)
                                        <p class="mb-0">
                                            <i class="bi bi-globe me-2 text-muted"></i> 
                                            <a href="{{ $branch->url }}" target="_blank" class="text-decoration-none">{{ $branch->url }}</a>
                                        </p>
                                        @endif
                                    </div>

                                    <!-- Información de ubicación -->
                                    <div class="col-md-3 mb-3">
                                        <h6 class="text-primary mb-3">Ubicación</h6>
                                        <p class="mb-2">
                                            <i class="bi bi-geo-alt me-2 text-muted"></i> 
                                            <span class="text-dark">{{ $branch->address ?? 'No especificada' }}</span>
                                        </p>
                                        <p class="mb-2">
                                            <span class="text-dark"><strong>Colonia:</strong> {{ $branch->colony ?? 'No especificada' }}</span>
                                        </p>
                                        <p class="mb-2">
                                            <span class="text-dark"><strong>C.P.:</strong> {{ $branch->zip_code ?? 'No especificado' }}</span>
                                        </p>
                                        <p class="mb-2">
                                            <span class="text-dark"><strong>Ciudad:</strong> {{ $branch->city ?? 'No especificada' }}</span>
                                        </p>
                                        <p class="mb-2">
                                            <span class="text-dark"><strong>Estado:</strong> {{ $branch->state ?? 'No especificado' }}</span>
                                        </p>
                                        <p class="mb-0">
                                            <span class="text-dark"><strong>País:</strong> {{ $branch->country ?? 'No especificado' }}</span>
                                        </p>
                                    </div>

                                    <!-- Información Fiscal -->
                                    <div class="col-md-3 mb-3">
                                        <h6 class="text-primary mb-3">Información Fiscal</h6>
                                        <p class="mb-2">
                                            <i class="bi bi-building me-2 text-muted"></i> 
                                            <span class="text-dark"><strong>Razón Social:</strong> {{ $branch->fiscal_name ?? 'No especificada' }}</span>
                                        </p>
                                        <p class="mb-2">
                                            <i class="bi bi-receipt me-2 text-muted"></i> 
                                            <span class="text-dark"><strong>Régimen Fiscal:</strong> {{ $branch->fiscal_regime ?? 'No especificado' }}</span>
                                        </p>
                                        <p class="mb-0">
                                            <i class="bi bi-file-text me-2 text-muted"></i> 
                                            <span class="text-dark"><strong>RFC:</strong> {{ $branch->rfc ?? 'No especificado' }}</span>
                                        </p>
                                    </div>

                                    <!-- Información adicional -->
                                    <div class="col-md-3 mb-3">
                                        <h6 class="text-primary mb-3">Información Adicional</h6>
                                        <p class="mb-2">
                                            <i class="bi bi-hash me-2 text-muted"></i> 
                                            <span class="text-dark">{{ $branch->code ?? 'No especificado' }}</span>
                                        </p>
                                        @if($branch->license_number)
                                        <p class="mb-0">
                                            <i class="bi bi-file-medical me-2 text-muted"></i> 
                                            <span class="text-dark">{{ $branch->license_number }}</span>
                                        </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Botón editar -->
                            <div class="position-absolute bottom-0 end-0 m-3">
                                <a href="{{ route('subscriptions.branch.edit', ['id' => $tenant->id, 'branch' => $branch->id]) }}" class="btn btn-action btn-edit" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('subscriptions.branch.user.create', ['id' => $tenant->id, 'branch' => $branch->id]) }}" class="btn btn-action btn-edit" title="Editar">
                                    <i class="fas fa-user-plus" title="Agregar usuario"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        @else
            <!-- Estado vacío -->
            <div class="text-center py-5">
                <div class="empty-state">
                    <i class="bi bi-building fs-1 text-muted"></i>
                    <h3 class="mt-3">No hay sucursales registradas</h3>
                    <p class="text-muted">Comienza agregando la primera sucursal para esta empresa.</p>
                    <a href="" class="btn btn-primary mt-3">
                        <i class="bi bi-plus-circle me-1"></i> Agregar Primera Sucursal
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
    .card {
        transition: transform 0.2s ease-in-out;
        border: 1px solid #e0e0e0;
    }
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    .card-header {
        background-color: #f8f9fa !important;
        border-bottom: 1px solid #dee2e6;
    }
    .empty-state {
        max-width: 400px;
        margin: 0 auto;
    }
    .text-muted {
        color: #6c757d !important;
    }

    .btn-action {
        padding: 8px 12px;
        border: none;
        background: #d1d3d6ff;
        color: #495057;
        font-size: 14px;
        transition: all 0.2s ease;
        border-radius: 6px;
    }

    .btn-action:hover {
        transform: translateY(-1px);
        color: #fff;
    }

    .btn-edit:hover { 
        background: #ffc107; 
        box-shadow: 0 2px 8px rgba(255, 193, 7, 0.3);
    }

    .btn-action i {
        transition: transform 0.2s ease;
    }

    .btn-action:hover i {
        transform: scale(1.1);
    }
</style>
@endsection