<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenantPermissionControl extends Model
{
    use HasFactory;

    protected $table = 'tenant_permission_control';

    protected $fillable = [
        'tenant_id',
        'permission_id', 
        'is_allowed'
    ];

    protected $casts = [
        'is_allowed' => 'boolean'
    ];

    // Relación con Tenant
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    // Relación con Permission de Spatie
    public function permission()
    {
        return $this->belongsTo(\Spatie\Permission\Models\Permission::class);
    }

    // Scope para permisos permitidos
    public function scopeAllowed($query)
    {
        return $query->where('is_allowed', true);
    }

    // Scope para permisos denegados
    public function scopeDenied($query)
    {
        return $query->where('is_allowed', false);
    }

    // Scope para un tenant específico
    public function scopeForTenant($query, $tenantId)
    {
        return $query->where('tenant_id', $tenantId);
    }

    // Buscar por nombre de permiso
    public function scopeForPermission($query, $permissionName)
    {
        return $query->whereHas('permission', function($q) use ($permissionName) {
            $q->where('name', $permissionName);
        });
    }
}