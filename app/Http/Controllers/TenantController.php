<?php

namespace App\Http\Controllers;

use App\Models\AppearanceSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

use App\Models\Plan;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Branch;
use App\Models\Company;
use App\Models\Administrative;
use App\Models\TenantPermissionControl;

use Spatie\Permission\Models\Role;
use Carbon\Carbon;


class TenantController extends Controller
{
    private $states_route = 'datas/json/Mexico_states.json';
    private $cities_route = 'datas/json/Mexico_cities.json';

    public function index()
    {
        $tenants = Tenant::all();
        $plans = Plan::all();
        $tenants->each(function ($tenant) {
            $tenant->subscription_start = $tenant->subscription_start ? Carbon::parse($tenant->subscription_start) : null;
            $tenant->subscription_end = $tenant->subscription_end ? Carbon::parse($tenant->subscription_end) : null;
        });
        return view('subscriptions_management.index', compact('tenants', 'plans'));
    }

    public function create()
    {
        $plans = Plan::all();
        $states = json_decode(file_get_contents(public_path($this->states_route)), true);
        $cities = json_decode(file_get_contents(public_path($this->cities_route)), true);
        return view('subscriptions_management.create', compact('plans', 'states', 'cities'));
    }

    /**
     * Crea la configuración de apariencia para un tenant
     * 
     * @param string $slug Identificador único del tenant
     * @param int $tenant_id ID del tenant
     * @param \Illuminate\Http\UploadedFile|null $logo Archivo de logo subido
     * @param string|null $primary_color Color primario personalizado
     * @param string|null $secondary_color Color secundario personalizado
     * @param string|null $custom_css CSS personalizado adicional
     * @return void
     */

    /**
     * Almacena una nueva suscripción/tenant en la base de datos
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validación actualizada con nuevos campos
        $validated = $request->validate([
            // Campos existentes de información general
            'company_name' => 'required|string|max:255',
            'branch_name' => 'required|string|max:255',
            'company_email' => 'required|string|max:255',
            'alt_email' => 'nullable|string|max:255',
            'company_phone' => 'required|string|max:255',
            'alt_phone' => 'nullable|max:255',
            'code' => 'nullable|integer|min:0',
            'address' => 'required|string|max:255',
            'colony' => 'required|string|max:255',
            'zip_code' => 'required|integer',
            'country' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'license_number' => 'nullable|string|max:255',

            // Campos existentes de información fiscal
            'fiscal_name' => 'nullable|string|max:255',
            'fiscal_regime' => 'nullable|string|max:255',
            'RFC' => 'nullable|string|max:255',

            // Campos existentes de configuración de suscripción
            'slug' => 'required|string|unique:tenant,slug',
            'plan_id' => 'required|integer|exists:plans,id',
            'limit_users' => 'required|integer|min:1', // NUEVO: Límite de usuarios ahora es requerido
            'subscription_start' => 'required|date',
            'subscription_end' => 'required|date|after:subscription_start',

            // Campos existentes del administrador
            'admin_name' => 'required|string|max:255',
            'admin_email' => 'required|email|unique:user,email',
            'username' => 'required|unique:user,username',
            'admin_password' => 'required|string|min:8|confirmed',

            // Campos existentes adicionales
            'URL' => 'nullable|string|max:255',

            // NUEVOS CAMPOS: Personalización y logo
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // NUEVO: Validación para logo
            'primary_color' => 'nullable|string|max:7|regex:/^#[0-9A-F]{6}$/i', // NUEVO: Color primario en formato HEX
            'secondary_color' => 'nullable|string|max:7|regex:/^#[0-9A-F]{6}$/i', // NUEVO: Color secundario en formato HEX
            'custom_css' => 'nullable|string|max:2000', // NUEVO: CSS personalizado con límite de caracteres
        ]);

        DB::beginTransaction();

        try {
            $slug = \Illuminate\Support\Str::slug($validated['slug']);

            // Crear el tenant con el límite de usuarios
            $tenant = Tenant::create([
                'company_name' => $validated['company_name'],
                'slug' => $slug,
                'is_active' => true,
                'plan_id' => $validated['plan_id'],
                'limit_users' => $validated['limit_users'], // NUEVO: Guardar límite de usuarios
                'subscription_start' => $validated['subscription_start'],
                'subscription_end' => $validated['subscription_end'],
                'path' => "{$slug}/",
            ]);

            // Recorrer la lista de permisos de spatie y crear las relaciones en tenant_permission_control
            $permissions = \Spatie\Permission\Models\Permission::all();

            foreach ($permissions as $permission) {
                TenantPermissionControl::create([
                    'tenant_id' => $tenant->id,
                    'permission_id' => $permission->id,
                    'is_allowed' => true
                ]);
            }

            $this->restrictionPermissionsPlan($tenant->id);

            // Crear usuario administrador 
            $adminUser = User::create([
                'name' => $validated['admin_name'],
                'username' => $validated['username'],
                'email' => $validated['admin_email'],
                'nickname' => $validated['admin_password'], // NOTA: Considerar cambiar esto por un campo más seguro
                'password' => Hash::make($validated['admin_password']),
                'tenant_id' => $tenant->id,
                'role_id' => 4,
                'type_id' => 1,
                'work_department_id' => 1,
                'status_id' => 2,
                'is_superAdmin' => false,
                'email_verified_at' => now(),
            ]);

            // Crear sucursal
            $branch = Branch::create([
                'tenant_id' => $tenant->id,
                'status_id' => 2,
                'name' => $validated['branch_name'],
                'code' => $validated['code'],
                'fiscal_name' => $validated['fiscal_name'],
                'email' => $validated['company_email'],
                'alt_email' => $validated['alt_email'],
                'phone' => $validated['company_phone'],
                'alt_phone' => $validated['alt_phone'],
                'address' => $validated['address'],
                'colony' => $validated['colony'],
                'zip_code' => $validated['zip_code'],
                'city' => $validated['city'],
                'state' => $validated['state'],
                'country' => $validated['country'],
                'license_number' => $validated['license_number'],
                'rfc' => $validated['RFC'],
                'fiscal_regime' => $validated['fiscal_regime'],
                'url' => $validated['URL'],
            ]);

            // Crear compañía
            $company = Company::create([
                'name' => $validated['company_name'],
                'tenant_id' => $tenant->id,
            ]);

            // Crear registro administrativo
            Administrative::insert([
                'tenant_id' => $tenant->id,
                'user_id' => $adminUser->id,
                'contract_type_id' => 1,
                'branch_id' => $branch->id,
                'company_id' => $company->id,
            ]);

            // Definir el permiso para el usuario
            $role = Role::where('simple_role_id', $adminUser->role_id)->where('work_id', $adminUser->work_department_id)->first();
            if ($role) {
                $adminUser->assignRole($role->name);
            }

            DB::commit();

            return redirect()->route('subscriptions.index')
                ->with('success', 'Suscripción y usuario administrador creados exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error al crear tenant: ' . $e->getMessage());

            // NUEVO: Try-catch sencillo para manejo específico de errores de validación de datos únicos
            try {
                // Verificar si el error es por duplicación de slug
                if (str_contains($e->getMessage(), 'tenant_slug_unique')) {
                    return back()->with('error', 'El identificador único ya está en uso. Por favor, elige otro.')->withInput();
                }

                // Verificar si el error es por duplicación de email
                if (str_contains($e->getMessage(), 'user_email_unique')) {
                    return back()->with('error', 'El correo electrónico del administrador ya está registrado.')->withInput();
                }

                // Verificar si el error es por duplicación de username
                if (str_contains($e->getMessage(), 'user_username_unique')) {
                    return back()->with('error', 'El nombre de usuario ya está en uso.')->withInput();
                }

                // Error genérico para otros tipos de errores
                return back()->with('error', 'Ocurrió un error inesperado al crear la suscripción. Por favor, intenta nuevamente.')->withInput();

            } catch (\Exception $secondaryError) {
                // En caso de que falle el manejo secundario de errores, retornar el error original
                return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
            }
        }
    }



    public function editView(Request $request, $id)
    {
        $tenant = Tenant::findOrFail($id);
        $plans = Plan::all();
        return view('subscriptions_management.edit', compact('tenant', 'plans'));

    }

    public function update(Request $request, $id)
    {

        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'plan_id' => 'required|integer|max:100',
            'subscription_start' => 'nullable|date',
            'subscription_end' => 'nullable|date|after_or_equal:subscription_start',
            'status_select' => 'required|string',
        ]);


        $tenant = Tenant::findOrFail($id);

        $tenant->update([
            'company_name' => $validated['company_name'],
            'plan_id' => $validated['plan_id'],
            'is_active' => $validated['status_select'] === 'true',
            'subscription_start' => $validated['subscription_start'] ?? null,
            'subscription_end' => $validated['subscription_end'] ?? null,
        ]);

        $this->restrictionPermissionsPlan($tenant->id);
        return redirect()->route('subscriptions.index')
            ->with('success', 'Suscripción actualizada correctamente.');
    }



    public function toggleStatus(Request $request, $id)
    {
        try {
            $tenant = Tenant::findOrFail($id);


            $isActive = filter_var($request->input('is_active', false), FILTER_VALIDATE_BOOLEAN);

            $tenant->update(['is_active' => $isActive]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Estado actualizado correctamente'
                ]);
            }

            return back()->with('success', 'Estado actualizado correctamente');

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Error al actualizar el estado');
        }
    }

    public function destroy($id)
    {
        try {
            $tenant = Tenant::find($id);

            if (!$tenant) {
                return redirect()
                    ->route('subscriptions.index')
                    ->with('error', 'No se pudo encontrar la suscripción.');
            }

            $tenant->update(['is_active' => false]);
            $tenant->delete();

            return redirect()
                ->route('subscriptions.index')
                ->with('success', 'Suscripción eliminada correctamente.');

        } catch (\Exception $e) {
            return redirect()
                ->route('subscriptions.index')
                ->with('error', 'Ocurrió un error al eliminar la suscripción: ' . $e->getMessage());
        }
    }

    public function branches($id)
    {

        $tenant = Tenant::findOrFail($id);
        $branches = Branch::where('tenant_id', $id)->get();

        return view('subscriptions_management.branch.branches', compact('tenant', 'branches'));
    }

    public function editBranch($tenantId, $branchId)
    {
        $states = json_decode(file_get_contents(public_path($this->states_route)), true);
        $cities = json_decode(file_get_contents(public_path($this->cities_route)), true);
        // Buscar el tenant y la sucursal
        $tenant = Tenant::findOrFail($tenantId);
        $branch = Branch::where('id', $branchId)
            ->where('tenant_id', $tenantId)
            ->firstOrFail();

        return view('subscriptions_management.branch.edit', compact('tenant', 'branch', 'states', 'cities'));
    }

    public function updateBranch(Request $request, $tenantId, $branchId)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'alt_email' => 'nullable|email|max:255',
            'alt_phone' => 'nullable|string|max:20',
            'url' => 'nullable|string|max:255',
            'address' => 'required|string|max:500',
            'colony' => 'required|string|max:255',
            'zip_code' => 'required|string|max:10',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'code' => 'nullable|integer|min:0',
            'license_number' => 'nullable|string|max:255',
            'fiscal_name' => 'nullable|string|max:255',
            'fiscal_regime' => 'nullable|string|max:255',
            'rfc' => 'nullable|string|max:20'
        ]);

        $branch = Branch::where('id', $branchId)
            ->where('tenant_id', $tenantId)
            ->firstOrFail();

        // Actualizar la sucursal
        $branch->update($validated);

        return redirect()->route('subscriptions.branches', $tenantId)
            ->with('success', 'Sucursal actualizada correctamente.');
    }

    public function admins($id)
    {
        $tenant = Tenant::findOrFail($id);

        // Obtener usuarios con roles de administrador
        $admins = User::where('tenant_id', $id)
            ->whereHas('roles', function ($query) {
                $query->whereIn('name', ['AdministradorDireccion', 'AdministradorRestringido', 'Super Admin']);
            })
            ->with('roles')
            ->get();

        return view('subscriptions_management.admins.index', compact('tenant', 'admins'));
    }

    public function adminsCreate($id)
    {
        $tenant = Tenant::where('id', $id)->first();

        return view('subscriptions_management.admins.create', compact('tenant'));
    }

    public function adminStore(Request $request, $id)
    {
        $tenant = Tenant::findOrFail($id);

        $validated = $request->validate([
            'admin_name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'admin_email' => 'required|email|unique:user,email|max:255',
            'admin_password' => 'required|string|min:8|confirmed',
        ]);

        $adminUser = User::create([
            'name' => $validated['admin_name'],
            'username' => $validated['username'],
            'email' => $validated['admin_email'],
            'nickname' => $validated['admin_password'],
            'password' => Hash::make($validated['admin_password']),
            'tenant_id' => $tenant->id,
            'role_id' => 4,
            'type_id' => 1,
            'work_department_id' => 1,
            'status_id' => 2,
            'is_superAdmin' => false,
            'email_verified_at' => now(),
        ]);

        // Definir el permiso para el usuario
        $role = Role::where('simple_role_id', $adminUser->role_id)->where('work_id', $adminUser->work_department_id)->first();
        if ($role) {

            $adminUser->assignRole($role->name);
        }
        return redirect()->route('subscriptions.admins', $tenant->id)
            ->with('success', 'Administrador creado correctamente.');
    }

    public function editAdmin($tenantId, $adminId)
    {
        $tenant = Tenant::findOrFail($tenantId);


        $admin = User::where('id', $adminId)
            ->where('tenant_id', $tenantId)
            ->firstOrFail();

        return view('subscriptions_management.admins.edit', compact('tenant', 'admin'));
    }

    public function updateAdmin(Request $request, $tenantId, $adminId)
    {
        // Validación
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:user,email,' . $adminId,
            'username' => 'required|string|max:255|unique:user,username,' . $adminId,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $admin = User::where('id', $adminId)
            ->firstOrFail();


        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'username' => $validated['username'],
        ];

        // contraseña
        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
            $data['nickname'] = $validated['password'];
        }

        $admin->update($data);

        return redirect()
            ->route('subscriptions.admins', $tenantId)
            ->with('success', 'Administrador actualizado correctamente.');
    }

    public function permissions($id)
    {
        $tenant = Tenant::findOrFail($id);
        $permissions = TenantPermissionControl::with('permission')
            ->where('tenant_id', $id)
            ->get();

        return view('permissions.index', compact('tenant', 'permissions'));
    }

    public function updatePermission(Request $request, $id)
    {
        $permission = TenantPermissionControl::findOrFail($id);
        $permission->update([
            'is_allowed' => $request->is_allowed
        ]);

        return back()->with('success', 'Permiso actualizado correctamente');
    }

    public function restrictionPermissionsPlan($tenantId)
    {

        $planPermissions = [
            1 => [
                'show_matrix',
                'handle_planning',
                'handle_crm',
                'handle_tracking',
                'handle_stock',
                'handle_client_system'
            ],
            2 => [
                'handle_crm',
                'show_matrix',
                'handle_planning',
                'handle_tracking',
                'handle_contracts',
                'handle_stock',
                'handle_rh',
                'handle_client_system'
            ],
            3 => [
                'handle_crm',
                'show_matrix',
                'show_sedes',
                'handle_tracking',
                'handle_quotes',
                'handle_planning',
                'handle_contracts',
                'handle_control_points',
                'handle_floorplans',
                'handle_quality',
                'handle_report_appearance',
                'show_quality_analytics',
                'handle_invoice',
                'handle_client_system',
                'handle_rh',
                'handle_files_employees',
                'handle_stock',
                'handle_product_technical_details',
                'assing_technician',
                'generate_voucher_stock',
                'show_stock_alerts',
                'handle_customer_zones'
            ]

        ];

        $tenant = Tenant::find($tenantId);

        $planId = $tenant->plan_id;

        // obtener permisos de categoría 't' manejo segun el tipo de plan
        $tenantPermissions = TenantPermissionControl::where('tenant_id', $tenant->id)
            ->whereHas('permission', function ($query) {
                $query->where('category', 't');
            })
            ->with('permission')
            ->get();

        foreach ($tenantPermissions as $tenantPermission) {
            $permissionName = $tenantPermission->permission->name;
            $isAllowed = in_array($permissionName, $planPermissions[$planId]) ? 1 : 0;

            $tenantPermission->update([
                'is_allowed' => $isAllowed,
                'updated_at' => now()
            ]);
        }
    }

    public function test()
    {

    }
}