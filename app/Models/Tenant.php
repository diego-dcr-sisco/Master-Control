<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;

class Tenant extends Model
{
    use HasFactory, SoftDeletes, HasRoles;
    protected $table = 'tenant';
    protected $fillable = [
        'company_name',
        'slug',
        'is_active',
        'plan_id',
        'subscription_start',
        'subscription_end',
        'path',
    ];

    protected $guard_name = 'web'; 

    protected $casts = [
        'is_active' => 'boolean',
        'subscription_start' => 'date',
        'subscription_end' => 'date',
        'deleted_at' => 'datetime'
    ];

   
    public function plan()
    {
        return $this->belongsTo(Plan::class)->withDefault([
            'name' => 'Plan Eliminado',
            'limit_users' => 0
        ]);
    }

    public function users()
    {
        return $this->hasMany(User::class, 'tenant_id');
    }
}