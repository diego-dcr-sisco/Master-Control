<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;
    protected $table = 'branch';
   
    protected $fillable = [
        'id',
        'tenant_id',
        'status_id',
        'name',
        'code',
        'fiscal_name',
        'email',
        'alt_email',
        'phone',
        'alt_phone',
        'address',
        'colony',
        'zip_code', 
        'city',
        'state',
        'country',
        'license_number', 
        'rfc', 
        'fiscal_regime', 
        'url',
        'description',
    ];

}
