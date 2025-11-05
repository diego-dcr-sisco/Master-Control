<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use App\Models\Status;
use App\Models\WorkDepartment;
use App\Models\SimpleRole;
use App\Models\Branch;
use App\Models\Company;
use App\Models\Filenames;
use App\Models\User;
use App\Models\Tenant;
use App\Models\UserFile;
use App\Models\Technician;
use App\Models\Administrative;
use App\Models\UserContract;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;



class UserController extends Controller
{
    
    private $files_path = 'users/files/';
	private static $states_route = 'datas/json/Mexico_states.json';
	private static $cities_route = 'datas/json/Mexico_cities.json';
	private $path = 'client_system/';
	private $user_path = 'users/';



	public function index(Request $request): View
	{
		$tenantId = $request->route('id'); 
		$users = User::where('tenant_id', $tenantId)->whereNot('role_id', 4)
				->orderBy('name', 'DESC')
                ->get();
		$roles = SimpleRole::where('id', '!=', 4)->get();
		$wk_depts = WorkDepartment::where('id', '!=', 1)->get();
		$types = ['Usuario Interno', 'Cliente'];


		return view(
			'users.index',
			compact(
				'users',
				'roles',
				'wk_depts',
				'tenantId',
				
			)
		);
	}

    public function create(Request $request): View
	{
        // Obtener el tenant y branch de  la ruta
        $tenantId = $request->route('id'); 
        $branchId = $request->route('branch');
        
        $tenant = Tenant::findOrFail($tenantId);
        $branch = Branch::findOrFail($branchId);

		$disk = Storage::disk('public');
		$local_dirs = $disk->directories($this->path);
		sort($local_dirs);
		$statuses = Status::all();
		$work_departments = WorkDepartment::where('id', '!=', 1)->get();
		$roles = SimpleRole::whereNotIn('id', [4, 5])->get();
		$companies = Company::all();


		return view(
			'users.create',
			compact(
				'local_dirs',
				'statuses',
				'work_departments',
				'roles',
				'companies',
                'tenant',
                'branch',
				
			)
		);
	}

    public function store(Request $request): RedirectResponse
	{

		$validated = $request->validate([
			'name' => 'required|string|max:255',
			'username' => 'required|string|max:20|unique:user,username',
			'email' => 'required|email|unique:user,email',
			'password' => 'required|min:8',
			'role_id' => 'required|exists:simple_role,id',
			'work_department_id' => 'required|exists:work_department,id',
		]);

		$type = 1;
		$files = Filenames::where('type', 'user')->get();
		$tenantId = $request->route('id'); 
		$branchId = $request->route('branch'); 
		$company = Company::where('tenant_id', $tenantId)->first();

		// Verificar que la compañía existe
		if (!$company) {
			return back()->with('error', 'No se encontró la compañía para este tenant')->withInput();
		}

		DB::beginTransaction();

		try {
			// Crear nuevo usuario
			$user = new User();
			$user->name = $validated['name'];
			$user->username = $validated['username'];
			$user->email = $validated['email'];
			$user->password = bcrypt($validated['password']);
			$user->nickname = $validated['password'];
			$user->role_id = $validated['role_id'];
			$user->work_department_id = $validated['work_department_id'];
			$user->status_id = 2;
			$user->type_id = $type;
			$user->tenant_id = $tenantId;
			$user->save();

			// Aumentar la cantidad de usuarios del tenant
			$tenant = Tenant::find($tenantId);
			$tenant->users_amount++;
			$tenant->save();

			// Archivos del usuario
			foreach ($files as $file) {
				UserFile::insert([
					'user_id' => $user->id,
					'filename_id' => $file->id,
				]);
			}

			// Asignar a la tabla correspondiente
			if ($user->role_id == 3) {
				$technician = new Technician();
				$technician->company_id = $company->id;
				$technician->tenant_id = $tenantId;
				$technician->user_id = $user->id;
				$technician->contract_type_id = 1;
				$technician->branch_id = $branchId;
				$technician->save();
			} else {
				$admin = new Administrative();
				$admin->user_id = $user->id;
				$admin->tenant_id = $tenantId;
				$admin->contract_type_id = 1;
				$admin->company_id = $company->id;
				$admin->branch_id = $branchId;
				$admin->save();

				if ($request->role_id == 2 && $request->work_department_id == 8) {
					$technician = new Technician();
					$technician->user_id = $user->id;
					$technician->contract_type_id = 1;
					$technician->save();
				}
			}

			// Crear contrato del usuario
			$user_contract = new UserContract();
			$user_contract->user_id = $user->id;
			$user_contract->contract_type_id = 1;
			$user_contract->save();

			// Definir permisos para el usuario
			$role = Role::where('simple_role_id', $user->role_id)
						->where('work_id', $user->work_department_id)
						->first();
			
			if ($role) {
				$user->syncRoles([$role->name]);
			}

			DB::commit();

			return redirect()->route('subscriptions.users.index', ['id' => $tenantId])
							->with('success', 'Usuario creado exitosamente.');

		} catch (\Exception $e) {
			DB::rollBack();
			\Log::error('Error al crear usuario: ' . $e->getMessage());
			return back()->with('error', 'Error al crear el usuario: ' . $e->getMessage())->withInput();
		}
	}

	public function edit(Request $request): View
	{
		
		$userId = $request->route('userId');
		$tenantId = $request->route('id');

		// Obtener el usuario a editar
		$user = User::findOrFail($userId);
		
		
		// Cargar datos para los dropdowns
		$statuses = Status::all();
		$work_departments = WorkDepartment::where('id', '!=', 1)->get();
		$roles = SimpleRole::whereNotIn('id', [4, 5])->get();
		$companies = Company::all();
		$branches = Branch::where('tenant_id', $tenantId)->get();

		return view('users.edit', compact(
			'user',  
			'statuses', 
			'work_departments', 
			'roles', 
			'companies',
			'userId',
			'tenantId',
			'branches',
		));
	}

	public function updateClient(Request $request, $id, $userId): RedirectResponse
	{
		// Validación de datos
		$validated = $request->validate([
			'name' => 'required|string|max:255',
			'username' => 'required|string|max:20|unique:user,username,' . $userId,
			'email' => 'required|email|unique:user,email,' . $userId,
			'password' => 'nullable|min:8',
		]);

		$tenantId = $request->route('id');
		$user = User::where('tenant_id', $tenantId)
					->where('id', $userId)
					->firstOrFail();

		// Actualizar datos básicos del usuario
		$user->name = $validated['name'];
		$user->username = $validated['username'];
		$user->email = $validated['email'];

		// Actualizar contraseña solo si se proporcionó
		if (!empty($validated['password'])) {
			$user->password = Hash::make($validated['password']);
			$user->nickname = $validated['password'];
		}

		$user->save();

		return redirect()->route('subscriptions.users.index', ['id' => $tenantId])
						->with('success', 'Usuario Cliente actualizado correctamente');
	}

	public function update(Request $request, $id, $userId): RedirectResponse
	{
		// Validación de datos
		$validated = $request->validate([
			'name' => 'required|string|max:255',
			'username' => 'required|string|max:20|unique:user,username,' . $userId,
			'email' => 'required|email|unique:user,email,' . $userId,
			'password' => 'nullable|min:8',
			'role_id' => 'required|exists:simple_role,id',
			'work_department_id' => 'required|exists:work_department,id',
			'branch_id' => 'required|exists:branch,id',
		]);

		$tenantId = $request->route('id');
		$branchId = $request->route('branch');
		$user = User::where('tenant_id', $tenantId)
					->where('id', $userId)
					->firstOrFail();

		// Actualizar datos básicos del usuario
		$user->name = $validated['name'];
		$user->username = $validated['username'];
		$user->email = $validated['email'];
		$user->role_id = $validated['role_id'];
		$user->work_department_id = $validated['work_department_id'];

		// Actualizar contraseña solo si se proporcionó
		if (!empty($validated['password'])) {
			$user->password = Hash::make($validated['password']);
			$user->nickname = $validated['password'];
		}

		$user->save();

		// Actualizar rol/permissions
		$role = Role::where('simple_role_id', $user->role_id)
					->where('work_id', $user->work_department_id)
					->first();
		
		if ($role) {
			$user->syncRoles([$role->name]);
		}

		// Actualizar registros relacionados
		$this->updateRelatedRecords($user, $request, $tenantId, $branchId);

		return redirect()->route('subscriptions.users.index', ['id' => $tenantId])
						->with('success', 'Usuario actualizado correctamente');
	}

	/**
	 * Actualizar registros relacionados (Technician o Administrative)
	 */
	private function updateRelatedRecords(User $user, Request $request, $tenantId, $branchId): void
	{
		$company = Company::where('tenant_id', $tenantId)->first();

		if ($user->role_id == 3) {
			// Actualizar o crear Technician
			$technician = Technician::where('user_id', $user->id)->first();
			
			if (!$technician) {
				$technician = new Technician();
			}
			
			$technician->fill($request->all());
			$technician->company_id = $company->id;
			$technician->tenant_id = $tenantId;
			$technician->user_id = $user->id;
			$technician->branch_id = $request->branch_id;
			$technician->contract_type_id = 1;
			$technician->save();

			// Eliminar Administrative si existe
			Administrative::where('user_id', $user->id)->delete();

		} else {
			// Actualizar o crear Administrative
			$admin = Administrative::where('user_id', $user->id)->first();
			
			if (!$admin) {
				$admin = new Administrative();
			}
			
			$admin->fill($request->all());
			$admin->user_id = $user->id;
			$admin->tenant_id = $tenantId;
			$admin->contract_type_id = 1;
			$admin->company_id = $company->id;
			$admin->branch_id = $request->branch_id;
			$admin->save();

			// Manejar caso especial de rol 2 con work_department 8
			if ($request->role_id == 2 && $request->work_department_id == 8) {
				$technician = Technician::where('user_id', $user->id)->first();
				
				if (!$technician) {
					$technician = new Technician();
				}
				
				$technician->fill($request->all());
				$technician->user_id = $user->id;
				$technician->contract_type_id = 1;
				$technician->save();
			} else {
				// Eliminar Technician si no cumple la condición
				Technician::where('user_id', $user->id)->delete();
			}
		}
	}
}
