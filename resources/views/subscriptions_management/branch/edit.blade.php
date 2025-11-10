@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Encabezado -->
    <div class="container-fluid mb-4">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('subscriptions.branches', $tenant->id) }}">
                <i class="bi bi-arrow-left fs-4"></i>
            </a>
            <div>
                <h4 class="mb-1 fw-bold">
                    EDITAR SUCURSAL - {{ $branch->name }}
                </h4>
                <p class="text-muted mb-0">{{ $tenant->company_name }}</p>
            </div>
        </div>
    </div>

    <!-- Formulario de edición -->
    <div class="container-fluid">
            <div class="card-body">
                <form action="{{ route('subscriptions.branch.update', ['id' => $tenant->id, 'branch' => $branch->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <!-- Información Básica -->
                        <div class="col-12 mb-4">
                            <h6 class="text-primary mb-3">Información Básica</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Nombre de la Sucursal <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name', $branch->name) }}" 
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                <label for="code" class="form-label">Código</label>
                                <input type="number" 
                                       class="form-control @error('code') is-invalid @enderror" 
                                       id="code" 
                                       name="code" 
                                       value="{{ old('code', $branch->code) }}"
                                       min="0"
                                       step="1"
                                       placeholder="Ej. 0">
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                 <small class="form-text text-muted">Solo números enteros estan permitidos. Ej. 0, 1, 2....</small>
                            </div>
                            </div>
                        </div>

                        <!-- Información de Contacto -->
                        <div class="col-12 mb-4">
                            <h6 class="text-primary mb-3">Información de Contacto</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email', $branch->email) }}" 
                                           required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Teléfono <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" 
                                           name="phone" 
                                           value="{{ old('phone', $branch->phone) }}" 
                                           required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="alt_email" class="form-label">Email Alternativo</label>
                                    <input type="email" 
                                           class="form-control @error('alt_email') is-invalid @enderror" 
                                           id="alt_email" 
                                           name="alt_email" 
                                           value="{{ old('alt_email', $branch->alt_email) }}">
                                    @error('alt_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="alt_phone" class="form-label">Teléfono Alternativo</label>
                                    <input type="text" 
                                           class="form-control @error('alt_phone') is-invalid @enderror" 
                                           id="alt_phone" 
                                           name="alt_phone" 
                                           value="{{ old('alt_phone', $branch->alt_phone) }}">
                                    @error('alt_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="url" class="form-label">Sitio Web</label>
                                    <input type="url" 
                                           class="form-control @error('url') is-invalid @enderror" 
                                           id="url" 
                                           name="url" 
                                           value="{{ old('url', $branch->url) }}" 
                                           placeholder="https://...">
                                    @error('url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Ubicación -->
                        <div class="col-12 mb-4">
                            <h6 class="text-primary mb-3">Ubicación</h6>
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label for="address" class="form-label">Dirección <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('address') is-invalid @enderror" 
                                           id="address" 
                                           name="address" 
                                           value="{{ old('address', $branch->address) }}" 
                                           required>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="colony" class="form-label">Colonia <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('colony') is-invalid @enderror" 
                                           id="colony" 
                                           name="colony" 
                                           value="{{ old('colony', $branch->colony) }}" 
                                           required>
                                    @error('colony')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="zip_code" class="form-label">Código Postal <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('zip_code') is-invalid @enderror" 
                                           id="zip_code" 
                                           name="zip_code" 
                                           value="{{ old('zip_code', $branch->zip_code) }}" 
                                           required>
                                    @error('zip_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="country" class="form-label">País <span class="text-danger">*</span></label>
                                    <select class="form-select @error('country') is-invalid @enderror" 
                                            id="country" 
                                            name="country" 
                                            required>
                                        <option value="Mex" {{ old('country', $branch->country) == 'Mex' ? 'selected' : '' }}>México</option>
                                    </select>
                                    @error('country')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="state" class="form-label">Estado <span class="text-danger">*</span></label>
                                    <select class="form-select @error('state') is-invalid @enderror" id="state" name="state"
                                        onchange="load_city()" required>
                                        <option value="" disabled>Selecciona un Estado</option>
                                        @foreach ($states as $state)
                                            <option value="{{ $state['key'] }}" 
                                                {{ old('state', $branch->state) == $state['key'] ? 'selected' : '' }}>
                                                {{ $state['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('state')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="city" class="form-label">Ciudad <span class="text-danger">*</span></label>
                                    <select class="form-select @error('city') is-invalid @enderror" id="city" name="city" required>
                                        <option value="" disabled>Selecciona un Municipio</option>
                                    </select>
                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                            </div>
                        </div>

                        <!-- Información Fiscal -->
                        <div class="col-12 mb-4">
                            <h6 class="text-primary mb-3">Información Fiscal</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="fiscal_name" class="form-label">Razón Social</label>
                                    <input type="text" 
                                           class="form-control @error('fiscal_name') is-invalid @enderror" 
                                           id="fiscal_name" 
                                           name="fiscal_name" 
                                           value="{{ old('fiscal_name', $branch->fiscal_name) }}"
                                           placeholder="Ingrese la Razón Social">
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
                                           value="{{ old('fiscal_regime', $branch->fiscal_regime) }}"
                                           placeholder="Ingrese el Régimen Fiscal">
                                    @error('fiscal_regime')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="rfc" class="form-label">RFC</label>
                                    <input type="text" 
                                           class="form-control @error('rfc') is-invalid @enderror" 
                                           id="rfc" 
                                           name="rfc" 
                                           value="{{ old('rfc', $branch->rfc) }}" 
                                           placeholder="Ingrese el RFC">
                                    @error('rfc')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Información Adicional -->
                        <div class="col-12 mb-4">
                            <h6 class="text-primary mb-3">Información Adicional</h6>
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label for="license_number" class="form-label">Licencia COFEPRIS</label>
                                    <input type="text" 
                                           class="form-control @error('license_number') is-invalid @enderror" 
                                           id="license_number" 
                                           name="license_number" 
                                           value="{{ old('license_number', $branch->license_number) }}"
                                           placeholder="Ingrese el número de licencia">
                                    @error('license_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('subscriptions.branches', $tenant->id) }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-1"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i> Actualizar Sucursal
                        </button>
                    </div>
                </form>
            </div>
        
    </div>
</div>

<script type="text/javascript">
    var currentCity = "{{ old('city', $branch->city) }}";
    
    function load_city() {
        var select_state = document.getElementById("state");
        var select_city = document.getElementById("city");
        var state = select_state.value;
        
    
        select_city.innerHTML = '<option value="" disabled>Selecciona un Municipio</option>';
        
        if (state != "") {
         
            var cities = {!! json_encode($cities) !!};
            var stateCities = cities[state];
            
            if (stateCities) {
                stateCities.forEach(function(c) {
                    var option = document.createElement("option");
                    option.text = c;
                    option.value = c;
                
                    if (c === currentCity) {
                        option.selected = true;
                    }
                    select_city.appendChild(option);
                });
            }
        }
    }
    
    function initializeSelects() {
        var currentState = "{{ old('state', $branch->state) }}";
        var select_state = document.getElementById("state");
        
        // estado actual
        if (currentState) {
            select_state.value = currentState;
            load_city();
        }
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        initializeSelects();
    });
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
@endsection