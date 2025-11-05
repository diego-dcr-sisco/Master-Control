@extends('layouts.app')
@section('content')
    @php
        function formatPath($path)
        {
            return str_replace(['/', ' '], ['-', ''], $path);
        }
    @endphp

    <div class="container-fluid p-0">
        <div class="d-flex align-items-center border-bottom ps-4 p-2">
            <a href="{{route('subscriptions.users.index', ['id' => $tenantId])}}" class="text-decoration-none pe-3">
                <i class="bi bi-arrow-left fs-4"></i>
            </a>
            <span class="text-black fw-bold fs-4">
                EDITAR USUARIO
            </span>
        </div>
        @if ($user->type_id==1)

        <form class="m-3" method="POST" action="{{ route('subscriptions.users.update', ['id' => $tenantId, 'userId' => $user->id]) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
                <div class="row">
                    <div class="fw-bold mb-2 fs-5">Datos del empleado</div>
                    
                    
                    <div class="col-lg-6 col-12 mb-3">
                        <label for="name" class="form-label is-required">Nombre Completo</label>
                        <input type="text" class="form-control" id="name" name="name" 
                            value="{{ $user->name }}" placeholder="Example"
                            autocomplete="off" maxlength="50" required />
                        @error('name')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-lg-6 col-12 mb-3">
                        <label for="username" class="form-label is-required">Usuario</label>
                        <input type="text" class="form-control" id="username" name="username" 
                            value="{{  $user->username }}" placeholder="Example"
                            autocomplete="off" maxlength="20" required />
                        @error('username')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-lg-6 col-12 mb-3">
                        <label for="email" class="form-label is-required">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ $user->email }}"
                            placeholder="ejemplo@correo.com"
                            autocomplete="off" 
                            required />
                        @error('email')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-lg-6 col-12 mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="password" name="password" 
                                value = "{{  $user->nickname }}" autocomplete="off" maxlength="20">
                            <button class="btn btn-warning" type="button" onclick="generatePassword()">
                                <i class="bi bi-arrow-clockwise"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="col-lg-4 col-12 mb-3">
                        <label for="branch" class="form-label">Sucursal</label>
                        <select class="form-select" name="branch_id" id="branch">
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}" 
                                    {{ old('branch_id', $user->branch_id) == $branch->id ? 'selected' : '' }}>
                                    {{ $branch->name }}
                                </option>
                            @endforeach
                        </select>
                    </div> 

                    <div class="col-lg-4 col-12 mb-3">
                        <label for="role" class="form-label">Rol</label>
                        <select class="form-select" id="role" name="role_id" onchange="restiction(this.value)">
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}" 
                                    {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('role_id')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-lg-4 col-12 mb-3">
                        <label for="work-department" class="form-label">Departamento</label>
                        <select class="form-select" id="wk-department" onchange="updateWorkDepartment()">
                            @foreach ($work_departments as $department)
                                <option class="option-department" value="{{ $department->id }}"
                                    {{ old('work_department_id', $user->work_department_id) == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('work_department_id')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <input type="hidden" name="type" value="1" />
                <input type="hidden" id="work-department" name="work_department_id" 
                    value="{{ old('work_department_id', $user->work_department_id) }}" />
                <input type="hidden" name="tenant_id" value="{{ $tenantId }}" />

             <!-- Botones de Acción -->
            <div class="row">
                <div class="col-12">
                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('subscriptions.users.index', ['id' => $tenantId]) }}" class="btn btn-secondary">
                        <i></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i></i> Actualizar
                        </button>
                    </div>

                </div>
                
            </div>
        </form>
        @elseif ($user->type_id == 2)
        <form class="m-3" method="POST" action="{{ route('subscriptions.users.update.client', ['id' => $tenantId, 'userId' => $user->id]) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
                <div class="row">
                    <div class="fw-bold mb-2 fs-5">Datos del cliente</div>
                    
                    <div class="col-lg-6 col-12 mb-3">
                        <label for="name" class="form-label is-required">Nombre Completo</label>
                        <input type="text" class="form-control" id="name" name="name" 
                            value="{{ old('name', $user->name) }}" placeholder="Example"
                            autocomplete="off" maxlength="50" required />
                        @error('name')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-lg-6 col-12 mb-3">
                        <label for="username" class="form-label is-required">Usuario</label>
                        <input type="text" class="form-control" id="username" name="username" 
                            value="{{ old('username', $user->username) }}" placeholder="Example"
                            autocomplete="off" maxlength="20" required />
                        @error('username')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-lg-6 col-12 mb-3">
                        <label for="email" class="form-label is-required">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ old('email', $user->email) }}" 
                            placeholder="ejemplo@correo.com"
                            autocomplete="off"
                            required />
                        @error('email')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-lg-6 col-12 mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="password" name="password" 
                                value = "{{ old('password',$user->nickname) }}" autocomplete="off" maxlength="20">
                            <button class="btn btn-warning" type="button" onclick="generatePassword()">
                                <i class="bi bi-arrow-clockwise"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="type" value="1" />
                <input type="hidden" id="work-department" name="work_department_id" 
                    value="{{ old('work_department_id', $user->work_department_id) }}" />
                <input type="hidden" name="tenant_id" value="{{ $tenantId }}" />

            
                <!-- Botones de Acción -->
            <div class="row">
                <div class="col-12">
                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('subscriptions.users.index', ['id' => $tenantId]) }}" class="btn btn-secondary">
                        <i></i> Canceler
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i></i> Actualizar
                        </button>
                    </div>

                </div>
                
            </div>
        </form>
        @endif

    </div>

<script>
function updateWorkDepartment() {
    const wkDepartment = document.getElementById('wk-department');
    const workDepartment = document.getElementById('work-department');
    workDepartment.value = wkDepartment.value;
}
</script>

<script src="{{ asset('js/user/actions.min.js') }}"></script>
@endsection