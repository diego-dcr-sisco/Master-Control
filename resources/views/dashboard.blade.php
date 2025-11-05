@extends('layouts.app')

@section('content')
<div class="container-fluid p-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-2 text-gray-800">Panel de Control Maestro</h1>
            <p class="mb-0">Bienvenido, <strong>{{ auth()->user()->name }}</strong>. Resumen completo del sistema.</p>
        </div>
        <div class="text-end">
            <small class="text-muted">Actualizado: {{ now()->format('d/m/Y H:i') }}</small>
        </div>
    </div>

    <!-- Estadísticas Principales -->
    <div class="row">
        <!-- Total Suscriptores -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Suscriptores
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $totalTenants }}
                            </div>
                            <div class="mt-2 mb-0 text-muted text-xs">
                                <span class="text-success mr-2">
                                    <i class="fas fa-arrow-up"></i> {{ $monthGrowth }}%
                                </span>
                                <span>crecimiento mensual</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-building fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Suscriptores Activos -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Suscriptores Activos
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $activeTenants }}
                            </div>
                            <div class="mt-2 mb-0 text-muted text-xs">
                                <span class="text-success mr-2">
                                    {{ number_format(($activeTenants / $totalTenants) * 100, 1) }}%
                                </span>
                                <span>del total</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Nuevos este Mes -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Nuevos este Mes
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $newThisMonth }}
                            </div>
                            <div class="mt-2 mb-0 text-muted text-xs">
                                <span class="text-info mr-2">
                                    <i class="fas fa-calendar"></i>
                                </span>
                                <span>{{ now()->format('F Y') }}</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ingreso Mensual Estimado -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Ingreso Mensual Estimado
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                ${{ number_format($monthlyRevenue, 2) }}
                            </div>
                            <div class="mt-2 mb-0 text-muted text-xs">
                                <span class="text-success mr-2">
                                    <i class="fas fa-dollar-sign"></i>
                                </span>
                                <span>revenue mensual</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Distribución de Planes -->
    <div class="row">
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Distribución de Planes</h6>
                </div>
                <div class="card-body">
                    <div class="chart-bar">
                        <canvas id="planDistributionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Resumen de Planes -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Resumen por Plan</h6>
                </div>
                <div class="card-body">
                    @foreach($planStats as $plan)
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold">{{ $plan->name }}</span>
                            <span class="badge badge-primary">{{ $plan->tenant_count }}</span>
                        </div>
                        <div class="progress mb-2" style="height: 8px;">
                            <div class="progress-bar bg-{{ $plan->color }}" 
                                 role="progressbar" 
                                 style="width: {{ ($plan->tenant_count / $totalTenants) * 100 }}%"
                                 aria-valuenow="{{ ($plan->tenant_count / $totalTenants) * 100 }}" 
                                 aria-valuemin="0" 
                                 aria-valuemax="100">
                            </div>
                        </div>
                        <small class="text-muted">
                            {{ number_format(($plan->tenant_count / $totalTenants) * 100, 1) }}% • 
                            ${{ number_format($plan->price, 2) }} /mes
                        </small>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Últimas Suscripciones y Métricas Rápidas -->
    <div class="row">
        <!-- Últimas Suscripciones -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Últimas Suscripciones</h6>
                    <a href="{{ route('subscriptions.index') }}" class="btn btn-sm btn-primary">Ver Todos</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Empresa</th>
                                    <th>Plan</th>
                                    <th>Fecha Inicio</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentTenants as $tenant)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-primary rounded-circle text-white d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                                {{ substr($tenant->company_name, 0, 1) }}
                                            </div>
                                            <strong>{{ $tenant->company_name }}</strong>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $tenant->plan->color ?? 'secondary' }}">
                                            {{ $tenant->plan->name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td>{{ $tenant->subscription_start->format('d/m/Y') }}</td>
                                    <td>
                                        @if($tenant->is_active)
                                            <span class="badge bg-success">Activo</span>
                                        @else
                                            <span class="badge bg-danger">Inactivo</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('subscriptions.edit.view', $tenant->id) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Métricas Rápidas -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Métricas del Sistema</h6>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <div class="mb-4">
                            <i class="fas fa-users fa-2x text-primary mb-2"></i>
                            <h4 class="font-weight-bold">{{ $totalUsers }}</h4>
                            <p class="text-muted">Usuarios Totales</p>
                        </div>
                        
                        <div class="mb-4">
                            <i class="fas fa-code-branch fa-2x text-success mb-2"></i>
                            <h4 class="font-weight-bold">{{ $totalBranches }}</h4>
                            <p class="text-muted">Sucursales</p>
                        </div>
                        
                        {{-- <div class="mb-4">
                            <i class="fas fa-database fa-2x text-info mb-2"></i>
                            <h4 class="font-weight-bold">{{ $storageUsage }}</h4>
                            <p class="text-muted">Almacenamiento Usado</p>
                        </div>
                        
                        <div class="mb-0">
                            <i class="fas fa-server fa-2x text-warning mb-2"></i>
                            <h4 class="font-weight-bold">{{ $systemUptime }}</h4>
                            <p class="text-muted">Tiempo Activo</p>
                        </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Acciones Rápidas -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Acciones Rápidas</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('subscriptions.create') }}" class="btn btn-primary btn-lg w-100 py-3">
                                <i class="fas fa-plus-circle fa-2x mb-2"></i><br>
                                Nueva Suscripción
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('subscriptions.index') }}" class="btn btn-success btn-lg w-100 py-3">
                                <i class="fas fa-list fa-2x mb-2"></i><br>
                                Gestionar Suscriptores
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('plans.index') }}" class="btn btn-info btn-lg w-100 py-3">
                                <i class="fas fa-cubes fa-2x mb-2"></i><br>
                                Administrar Planes
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="#" class="btn btn-warning btn-lg w-100 py-3">
                                <i class="fas fa-chart-bar fa-2x mb-2"></i><br>
                                Reportes Detallados
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gráfico de distribución de planes
    const planCtx = document.getElementById('planDistributionChart').getContext('2d');
    
    const planChart = new Chart(planCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($planStats->pluck('name')->toArray()) !!},
            datasets: [{
                label: 'Suscriptores por Plan',
                data: {!! json_encode($planStats->pluck('tenant_count')->toArray()) !!},
                backgroundColor: [
                    '#4e73df', 
                    '#1cc88a',  
                    '#f6c23e', 
                    '#e74a3b', 
                    '#36b9cc', 
                    '#858796'  
                ],
                borderColor: [
                    '#4e73df',
                    '#1cc88a',
                    '#f6c23e', 
                    '#e74a3b',
                    '#36b9cc',
                    '#858796'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: 'Distribución de Suscriptores por Plan'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
});
</script>

@push('styles')
<style>
.avatar-sm {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 14px;
}

.border-left-primary { border-left: 4px solid #4e73df !important; }
.border-left-success { border-left: 4px solid #1cc88a !important; }
.border-left-info { border-left: 4px solid #36b9cc !important; }
.border-left-warning { border-left: 4px solid #f6c23e !important; }

.card {
    border: 1px solid #e3e6f0;
    border-radius: 0.35rem;
}

.progress {
    border-radius: 10px;
}

.badge-primary { background-color: #4e73df; }
.badge-success { background-color: #1cc88a; }
.badge-info { background-color: #36b9cc; }
.badge-warning { background-color: #f6c23e; }
.badge-danger { background-color: #e74a3b; }

.btn-lg {
    border-radius: 0.5rem;
    font-weight: 600;
}
</style>
@endpush