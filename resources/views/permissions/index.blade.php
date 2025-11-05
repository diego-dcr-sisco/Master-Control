@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">

    <!-- Encabezado de la página -->
    <div class="row border-bottom mb-3">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('subscriptions.index') }}" >
                <i class="bi bi-arrow-left fs-4"></i>
            </a>
            <div>
                <h4 class="mb-1 fw-bold">
                    GESTIÓN DE PERMISOS - {{ $tenant->company_name }}
                </h4>
                <p class="text-muted mb-0">Administre los permisos para esta suscripción</p>
            </div>
        </div>
    </div>

    <div class="container-fluid pt-4"> 
        <table class="table table-striped table-hover">
        <thead class="table-light">
            <tr>
                <th class="fw-bold" scope="col">Permiso</th>
                <th class="fw-bold" scope="col">Estado</th>
                <th class="fw-bold" scope="col">Tipo</th>
                <th class="fw-bold" scope="col">Cambiar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($permissions as $permission)
            <tr>
                <td>{{ $permission->permission->name }}</td>
                <td>
                    @if($permission->is_allowed)
                        <i class="fas fa-check-circle text-success fa-lg" title="Permitido"></i><span class="ms-2 fw-bold text-success">Permitido</span>
                    @else
                        <i class="fas fa-times-circle text-danger fa-lg" title="Denegado"></i><span class="ms-2 fw-bold text-danger">Sin permiso</span>
                    @endif
                </td>
                <td>
                     {{ $permission->permission->category ? $permission->permission->category : 'Sin categoría'  }}
                </td>
                <td>
                    <form method="POST" action="{{ route('subscriptions.permission.update', $permission->id) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="is_allowed" value="{{ $permission->is_allowed ? 0 : 1 }}">
                        <button type="submit" class="btn btn-sm fw-bold {{ $permission->is_allowed ? 'btn-outline-danger' : 'btn-outline-success' }}">
                            {{ $permission->is_allowed ? 'Quitar permiso' : 'Permitir' }}
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    </div> 
</div>
@endsection
