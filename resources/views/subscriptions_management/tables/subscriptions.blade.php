<table class="table table-striped table-hover">
                <thead class="table-light">
                    <tr>
                        <th class="fw-bold" scope="col">ID</th>
                        <th class="fw-bold" scope="col">Compañía</th>
                        <th class="fw-bold" scope="col">Usuario</th>
                        <th class="fw-bold" scope="col">Estado</th>
                        <th class="fw-bold" scope="col">Plan</th>
                        <th class="fw-bold" scope="col">Inicio</th>
                        <th class="fw-bold" scope="col">Expira</th>
                        <th class="fw-bold" scope="col">No.Usuarios</th>
                        <th class="fw-bold" scope="col">Vigencia</th>
                        <th class="fw-bold" scope="col"></th>
                    </tr>
                </thead>
                <tbody id="table-body">
                    @foreach ($tenants as $index => $tenant)
                        <tr id="subscription{{ $tenant->id }}">
                            <th>{{ $tenant->id }}</th>
                            <td><i class="bi bi-building-fill"></i> {{ $tenant->company_name }}</td>
                            <td>{{ $tenant->slug }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <!-- Badge de estado -->
                                    <span data-tenant-status="{{ $tenant->id }}">
                                        {{ $tenant->is_active ? 'Activo' : 'Inactivo' }}
                                    </span>

                                    <!-- Botón visual de estado estado -->
                                        <div class="form-check form-switch">
                                            <input class="form-check-input switch-toggle" 
                                                type="checkbox" 
                                                id="switch{{ $tenant->id }}" data-tenant-id="{{ $tenant->id }}" disabled data-company-name="{{ $tenant->company_name }}" 
                                                {{ $tenant->is_active ? 'checked' : '' }}>
                                            <label class="form-check-label" for="switch{{ $tenant->id }}"></label>
                                        </div>
                                    
                            </td>
                            <td>{{ $tenant->plan->name }}</td>
                            <td>{{ $tenant->subscription_start ? $tenant->subscription_start->format('d/m/Y') : '-' }}</td>
                            <td>{{ $tenant->subscription_end ? $tenant->subscription_end->format('d/m/Y') : '-' }}</td>
                            <td>{{ $tenant->users_amount }}</td>
                            <td>
                                @php
                                    $daysLeft = now()->diffInDays($tenant->subscription_end, false);
                                @endphp
                                <span>
                                     {{ $daysLeft > 0 ? 'Vigente' : 'Expirado' }}
                                </span>
                            </td>
                            <td class="text-center">
                                        <div class="btn-group btn-group-options" role="group">
                                            <!-- Botón de editar Suscripción -->
                                            <a href="{{ route('subscriptions.edit.view', $tenant->id) }}" class="btn btn-action btn-bk" title="Editar suscripción">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <!-- Botón de Sucursales -->
                                            <a href="{{ route('subscriptions.branches', $tenant->id) }}" class="btn btn-action btn-bk" title="Sucursales">
                                                <i class="fas fa-code-branch"></i>
                                            </a>

                                            <!-- Botón de Administradores -->
                                            <a href="{{ route('subscriptions.admins', $tenant->id) }}" class="btn btn-action btn-bk" title="Administradores">
                                                <i class="fas fa-user-cog"></i>
                                            </a>

                                            <!-- Botón de Lista de Usuarios -->
                                            <a href="{{ route('subscriptions.users.index', $tenant->id) }}" class="btn btn-action btn-bk" title="Usuarios">
                                                <i class="fas fa-users"></i>
                                            </a>

                                            <!-- Botón de Lista de Permisos -->
                                            <a href="{{ route('subscriptions.permissions', $tenant->id) }}" class="btn btn-action btn-bk" title="Permisos">
                                                <i class="fas fa-shield"></i>
                                            </a>
                                        </div>
                                    </td>
                        </tr>
                    @endforeach
                </tbody>
 </table>


<style>

    .form-switch .form-check-input {
        height: 1.5rem;
        width: 2.75rem;
        cursor: pointer;
    }

    .form-switch .form-check-input:checked {
        background-color: #28a745;
        border-color: #28a745;
    }

    .form-switch .form-check-input:focus {
        border-color: rgba(40, 167, 69, 0.25);
        box-shadow: 0 0 0 0.25rem rgba(40, 167, 69, 0.25);
    }

    /* Switch con animación suave */
    .form-check-input {
        transition: all 0.3s ease;
    }

    /* Efecto hover */
    .form-switch:hover .form-check-input {
        transform: scale(1.05);
    }
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.switch-toggle').forEach(switchInput => {
        switchInput.addEventListener('change', function(e) {
            e.preventDefault();
            
            const tenantId = this.dataset.tenantId;
            const isActive = this.checked;
            
            const statusElement = document.querySelector(`[data-tenant-status="${tenantId}"]`);
            if (statusElement) {
                statusElement.textContent = isActive ? 'Activo' : 'Inactivo';
                statusElement.className = isActive ? 'badge bg-success' : 'badge bg-danger';
            }
        });
    });
});
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">