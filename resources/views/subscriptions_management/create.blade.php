@extends('layouts.app')

@section('content')
<div class="container-fluid p-3">
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('subscriptions.index') }}">
            <i class="bi bi-arrow-left fs-4"></i>
        </a>
        <h4 class="fw-bold">CREAR NUEVA SUSCRIPCIÓN</h4>
    </div>
    <div class="container-fluid">
        <div class="col-12">
                <div>
                    <form action="{{ route('subscriptions.store') }}" method="POST" id="tenantForm">
                        @csrf
                        <!-- Información General -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-primary mb-3">Información General</h5>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="company_name" class="form-label">Nombre de la Empresa/Organización  <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('company_name') is-invalid @enderror" 
                                       id="company_name" 
                                       name="company_name" 
                                       value="{{ old('company_name') }}" 
                                       required
                                       placeholder="Ingrese el nombre de la empresa">
                                @error('company_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="branch_name" class="form-label">Nombre de la Sucursal  <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('branch_name') is-invalid @enderror" 
                                       id="branch_name" 
                                       name="branch_name" 
                                       value="{{ old('branch_name') }}"
                                       placeholder="Ingrese el nombre de la Sede/Sucursal Matriz">
                                @error('branch_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="company_email" class="form-label">Correo  <span class="text-danger">*</span></label>
                                <input type="email" 
                                       class="form-control @error('company_email') is-invalid @enderror" 
                                       id="company_email" 
                                       name="company_email" 
                                       value="{{ old('company_email') }}" 
                                       required
                                       placeholder="Ingrese el correo de contacto de la empresa">
                                @error('company_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="alt_email" class="form-label">Correo alternativo</label>
                                <input type="email" 
                                       class="form-control @error('alt_email') is-invalid @enderror" 
                                       id="alt_email" 
                                       name="alt_email" 
                                       value="{{ old('alt_email') }}"
                                       placeholder="Ingrese el correo de contacto alternativo de la empresa">
                                @error('alt_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="URL" class="form-label">Sitio Oficial</label>
                                <input type="text" 
                                       class="form-control @error('URL') is-invalid @enderror" 
                                       id="URL" 
                                       name="URL" 
                                       value="{{ old('URL') }}" 
                                       placeholder="www.oficial.mx">
                                @error('URL')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="company_phone" class="form-label">Teléfono  <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('company_phone') is-invalid @enderror" 
                                       id="company_phone" 
                                       name="company_phone" 
                                       value="{{ old('company_phone') }}" 
                                       required
                                       placeholder="Número de contacto">
                                @error('company_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="alt_phone" class="form-label">Teléfono alternativo </label>
                                <input type="text" 
                                       class="form-control @error('alt_phone') is-invalid @enderror" 
                                       id="alt_phone" 
                                       name="alt_phone" 
                                       value="{{ old('alt_phone') }}" 
                                       placeholder="Número alternativo de contacto">
                                @error('alt_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="code" class="form-label">Código</label>
                                <input type="number" 
                                       class="form-control @error('code') is-invalid @enderror" 
                                       id="code" 
                                       name="code" 
                                       value="{{ old('code') }}"
                                       min="0"
                                       step="1"
                                       placeholder="Ej. 0">
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                 <small class="form-text text-muted">Solo números enteros estan permitidos. Ej. 0, 1, 2....</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="address" class="form-label">Dirección  <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('address') is-invalid @enderror" 
                                       id="address" 
                                       name="address" 
                                       value="{{ old('address') }}" 
                                       required
                                       placeholder="#Número, Calle">
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="colony" class="form-label">Colonia  <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('colony') is-invalid @enderror" 
                                       id="colony" 
                                       name="colony" 
                                       value="{{ old('colony') }}" 
                                       required
                                       placeholder=" ">
                                @error('colony')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="zip_code" class="form-label">Código Postal  <span class="text-danger">*</span></label>
                                <input type="number" 
                                       class="form-control @error('zip_code') is-invalid @enderror" 
                                       id="zip_code" 
                                       name="zip_code" 
                                       value="{{ old('zip_code') }}" 
                                       required
                                       placeholder=" ">
                                @error('zip_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="country" class="form-label">País  <span class="text-danger">*</span></label>
                                <select class="form-select  bg-secondary-subtle" id="country" name="country" required>
                                    <option value="Mex">México</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="state" class="form-label">Estado  <span class="text-danger">*</span></label>
                                <select class="form-select @error('state') is-invalid @enderror" id="state" name="state"
                                    onchange="load_city()" required>
                                    <option value="" selected disabled hidden>Selecciona un Estado</option>
                                    @foreach ($states as $state)
                                        <option value="{{ $state['key'] }}">{{ $state['name'] }}</option>
                                    @endforeach
                                </select>
                                @error('state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="city" class="form-label">Ciudad  <span class="text-danger">*</span></label>
                                <select type="text" class="form-select @error('city') is-invalid @enderror " id="city" name="city"
                                    required>
                                </select>
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="license_number" class="form-label">NO. de licencia sanitaria (COFEPRIS) </label>
                                <input type="text" 
                                       class="form-control @error('license_number') is-invalid @enderror" 
                                       id="license_number" 
                                       name="license_number" 
                                       value="{{ old('license_number') }}" 
                                       placeholder=" ">
                                @error('license_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <!-- Información Fiscal -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-primary mb-3">Información Fiscal</h5>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="fiscal_name" class="form-label">Razón Social</label>
                                <input type="text" 
                                       class="form-control @error('fiscal_name') is-invalid @enderror" 
                                       id="fiscal_name" 
                                       name="fiscal_name" 
                                       value="{{ old('fiscal_name') }}" 
                                       placeholder="Ingrese la Razón Social de la Empresa/Organización">
                                @error('fiscal_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="fiscal_regime" class="form-label">Régimen Fiscal</label>
                                <input type="text" 
                                       class="form-control @error('fiscal_regime') is-invalid @enderror" 
                                       id="fiscal_regime" 
                                       name="fiscal_regime" 
                                       value="{{ old('fiscal_regime') }}"
                                       placeholder="Ingrese el Régimen Fiscal de la Empresa/Organización">
                                @error('fiscal_regime')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="RFC" class="form-label">RFC  <span class="text-danger"></label>
                                <input type="text" 
                                       class="form-control @error('RFC') is-invalid @enderror" 
                                       id="RFC" 
                                       name="RFC" 
                                       value="{{ old('RFC') }}"
                                       placeholder="RFC">
                                @error('RFC')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <!-- Información del Tenant -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-primary mb-3">Configuración de Suscripción</h5>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="slug" class="form-label">Identificador único del Suscriptor  <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" 
                                           class="form-control @error('slug') is-invalid @enderror" 
                                           id="slug" 
                                           name="slug" 
                                           value="{{ old('slug') }}" 
                                           required
                                           placeholder="Identificador único">
                                    <span class="input-group-text">/</span>
                                </div>
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted"> Identificador único del suscriptor</small>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="plan_id" class="form-label">Plan  <span class="text-danger">*</span></label>
                                <select class="form-select @error('plan_id') is-invalid @enderror" 
                                        id="plan_id" 
                                        name="plan_id" 
                                        required>
                                    <option value="">Seleccionar plan</option>
                                    @foreach($plans as $plan)
                                        <option value="{{ $plan->id }}" 
                                                data-limit-users="{{ $plan->limit_users }}"
                                                {{ old('plan_id') == $plan->id ? 'selected' : '' }}>
                                            {{ $plan->name }}
                                        </option>

                                    @endforeach
                                </select>
                                @error('plan_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="limit_users" class="form-label">Límite de Usuarios  <span class="text-danger">*</span></label>
                                <input type="number" 
                                    class="form-control @error('limit_users') is-invalid @enderror" 
                                    id="limit_users" 
                                    name="limit_users" 
                                    value="{{ old('limit_users') }}" 
                                    disabled
                                    placeholder="Seleccione un plan primero">
                                    
                                @error('limit_users')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="subscription_start" class="form-label">Fecha de Inicio  <span class="text-danger">*</span></label>
                                <input type="date" 
                                       class="form-control @error('subscription_start') is-invalid @enderror" 
                                       id="subscription_start" 
                                       name="subscription_start" 
                                       value="{{ old('subscription_start', date('Y-m-d')) }}"
                                       required>
                                @error('subscription_start')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="subscription_end" class="form-label">Fecha de Término  <span class="text-danger">*</span></label>
                                <input type="date" 
                                       class="form-control @error('subscription_end') is-invalid @enderror" 
                                       id="subscription_end" 
                                       name="subscription_end" 
                                       value="{{ old('subscription_end') }}"
                                       required
                                       placeholder="subscription_end">
                                @error('subscription_end')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <!-- Información del Administrador del Tenant -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-primary mb-3">Administrador de la Suscripción</h5>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="admin_name" class="form-label">Nombre del Administrador  <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('admin_name') is-invalid @enderror" 
                                       id="admin_name" 
                                       name="admin_name" 
                                       value="{{ old('admin_name') }}" 
                                       required
                                       placeholder="Ej. Administrador">
                                @error('admin_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="username" class="form-label">Usuario  <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('username') is-invalid @enderror" 
                                       id="username" 
                                       name="username" 
                                       value="{{ old('username') }}" 
                                       required
                                       placeholder="Usuario">
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="admin_email" class="form-label">Email del Administrador  <span class="text-danger">*</span></label>
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
                                <label for="admin_password" class="form-label">Contraseña  <span class="text-danger">*</span></label>
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
                                <label for="admin_password_confirmation" class="form-label">Confirmar Contraseña  <span class="text-danger">*</span></label>
                                <input type="password" 
                                       class="form-control" 
                                       id="admin_password_confirmation" 
                                       name="admin_password_confirmation" 
                                       required
                                       placeholder="Reingrese la contraseña">
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex gap-2 justify-content-end">
                                    <button type="reset" class="btn btn-outline-secondary">
                                        <i class="fas fa-redo me-2"></i>Limpiar
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-circle me-1"></i>Crear Suscripción
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            
        </div>
    </div>
</div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Generar slug automáticamente a partir del nombre de la empresa
    const companyNameInput = document.getElementById('company_name');
    const usernameInput = document.getElementById('slug');
    
    if (companyNameInput && usernameInput) {
        companyNameInput.addEventListener('blur', function() {
            if (this.value && !usernameInput.value) {
                // Convertir a slug: minúsculas, sin espacios, sin caracteres especiales
                const slug = this.value
                    .toLowerCase()
                    .trim()
                    .replace(/[^a-z0-9]/g, '-')
                    .replace(/-+/g, '-')
                    .replace(/^-|-$/g, '');
                
                usernameInput.value = slug;
            }
        });
    }

    // Validación del formulario
    const form = document.getElementById('tenantForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            const password = document.getElementById('admin_password').value;
            const confirmPassword = document.getElementById('admin_password_confirmation').value;
            
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Las contraseñas no coinciden');
                return false;
            }
            
            if (password.length < 8) {
                e.preventDefault();
                alert('La contraseña debe tener al menos 8 caracteres');
                return false;
            }

            // Validar que la fecha de término sea posterior a la de inicio
            const startDate = document.getElementById('subscription_start').value;
            const endDate = document.getElementById('subscription_end').value;
            
            if (endDate && startDate && endDate <= startDate) {
                e.preventDefault();
                alert('La fecha de término debe ser posterior a la fecha de inicio');
                return false;
            }

            const slug = document.getElementById('slug').value;
            // Validar que no esté vacío
            if (!slug || slug.trim() === '') {
                e.preventDefault();
                alert('El identificador de la suscripción no puede estar vacío');
                return false;
            }
                
            // Validar formato del slug con regex directo
            const slugRegex = /^[a-z0-9]+(?:-[a-z0-9]+)*$/;
            if (!slugRegex.test(slug)) {
                e.preventDefault();
                alert('Error en el Identificador de Suscriptor:\n• Solo letras minúsculas (a-z)\n• No se aceptan espacios\n• Números (0-9)\n• Guiones medios (-)\n• No puede empezar/terminar con guión\n• No puede tener guiones consecutivos\n• Ejemplo válido: mi-empresa-123');
                return false;
            }
            
        });
    }

    // Establecer fecha mínima para la fecha de término
    const startDateInput = document.getElementById('subscription_start');
    const endDateInput = document.getElementById('subscription_end');
    
    if (startDateInput && endDateInput) {
        startDateInput.addEventListener('change', function() {
            endDateInput.min = this.value;
            
            // Si la fecha de término es anterior a la nueva fecha de inicio, limpiarla
            if (endDateInput.value && endDateInput.value < this.value) {
                endDateInput.value = '';
            }
        });
    }

    //límite de usuarios
    const planSelect = document.getElementById('plan_id');
    const limitUsersInput = document.getElementById('limit_users');

    if (planSelect && limitUsersInput) {
        const updateUserLimit = () => {
            const selectedOption = planSelect.options[planSelect.selectedIndex];
            
            if (selectedOption && selectedOption.value !== '') {
                const limitUsers = selectedOption.getAttribute('data-limit-users');
                limitUsersInput.value = limitUsers;       
            } 
            else{
                limitUsersInput.value = '';
                limitUsersInput.placeholder = 'Seleccione un plan primero';
            }
        }

        planSelect.addEventListener('change', updateUserLimit);
        updateUserLimit();
    

    

    
    }

});
</script>
<script type="text/javascript">
    function load_city() {
        var select_state = document.getElementById("state");
        var select_city = document.getElementById("city");
        var state = select_state.value;
        // Borra las opciones actuales de select_city
        select_city.innerHTML =
            '<option value="" selected disabled hidden>Selecciona un municipio</option>';
        if (state != "") {
            // Obtén los municipios correspondientes al city seleccionado del JSON
            var cities = {!! json_encode($cities) !!};
            var city = cities[state];
            city.forEach(function(c) {
                var option = document.createElement("option");
                option.text = c;
                option.value = c;
                select_city.appendChild(option);
            });
        }
    }
</script>

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
