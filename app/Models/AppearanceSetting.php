<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppearanceSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'tenant_id',
        'primary_color',
        'secondary_color',
        'logo_path',
        'watermark_path',
        'watermark_opacity',
        'created_at',
        'updated_at'
    ];

    protected $attributes = [
        'primary_color' => '#64b5f6',
        'secondary_color' => '#b0bec5',
        'logo_path' => 'images/zonda/landscape_logo.png',
        'watermark_path' => 'images/zonda/watermark.png',
        'watermark_opacity' => 0.1
    ];
}
