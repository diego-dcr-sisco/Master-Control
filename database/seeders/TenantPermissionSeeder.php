<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\SimpleRole;


class TenantPermissionSeeder extends Seeder {

	public function run(): void {
		$permissions = [
			[
				'name' => 'show_matrix', 
				'category' => 't',
				'type' => 'w',
			],
			[
				'name' => 'show_sedes', 
				'category' => 't',
				'type' => 'w',
			],
			[
				'name' => 'handle_crm',
				'category' => 't',
				'type' => 'w',
			],
			[
				'name' => 'handle_tracking',
				'category' => 't',
				'type' => 'w',
			],
			[
				'name' => 'handle_quotes',
				'category' => 't', 
				'type' => 'w'
			],
			[
				'name' => 'handle_planning',
				'category' => 't', 
				'type' => 'w',
			],
			[ 
				'name' => 'handle_contracts',
				'category' => 't',
				'type' => 'w',
			],
			[
				'name' => 'handle_control_points',
				'category' => 't', 
				'type' => 'w',
			],
			[
				'name' => 'handle_floorplans',
				'category' => 't',
				'type' => 'w',
			],
			[
				'name' => 'handle_quality',
				'category' => 't', 
				'type' => 'w',
			],
			[
				'name' => 'handle_report_appearance',
				'category' => 't', 
				'type' => 'w',
			],
			[
				'name' => 'show_quality_analytics',
				'category' => 't',
				'type' => 'w'
			],
			[
				'name' => 'handle_invoice',
				'category' => 't', 
				'type' => 'w'
			],
			[
				'name' => 'handle_client_system', 
				'category' => 't',
				'type' => 'w'
			],
            [
				'name' => 'handle_rh',
				'category' => 't',
				'type' => 'w'
			],
            [
				'name' => 'handle_files_employees',
				'category' => 't',
				'type' => 'w'
			],
            [
				'name' => 'handle_stock',
				'category' => 't', 
				'type' => 'w'
			],
            [
				'name' => 'handle_product_technical_details',
				'category' => 't',
				'type' => 'w'
			],
            [
				'name' => 'assing_technician',
				'category' => 't',
				'type' => 'w'
			],
            [
				'name' => 'generate_voucher_stock',
				'category' => 't', 
				'type' => 'w'
			],
            [
				'name' => 'show_stock_alerts',
				'category' => 't', 
				'type' => 'w'
			],
			[
				'name' => 'handle_customer_zones',
				'category' => 't', 
				'type' => 'w'
			],
		];

		$data = array_map(function ($permission) {
			return [
				'name' => $permission['name'],
				'category' => $permission['category'],
				'type' => $permission['type'],
				'guard_name' => 'web',
				'created_at' => now(),
				'updated_at' => null,
			];
		}, $permissions);

		Permission::insert($data);


		$this->command->info('Permisos de tenant creados exitosamente.');

		// Asignar estos permisos a los roles administrativos
		$tenantPermissions = Permission::where('category', 't')->get();
		
		if ($tenantPermissions->isEmpty()) {
			$this->command->info('No se encontraron permisos de categoría tenant.');
			return;
		}

		// Roles que deben tener todos los permisos de tenant
		$adminRoles = SimpleRole::whereIn('id', [1, 2, 4])->get(); // Administrativo, Supervisor, Administrador
		
		foreach ($adminRoles as $simpleRole) {
			// Obtener todos los roles Spatie asociados a este simpleRole
			$roles = Role::where('simple_role_id', $simpleRole->id)->get();
			
			foreach ($roles as $role) {
				// Asignar todos los permisos de tenant
				$role->givePermissionTo($tenantPermissions->pluck('name')->toArray());
				
				$this->command->info("Asignados {$tenantPermissions->count()} permisos tenant al rol: {$role->name}");
			}
		}

		$this->command->info('Todos los permisos de tenant han sido asignados a roles administrativos.');
	}

}
