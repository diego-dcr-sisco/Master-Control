<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\Plan;
use App\Models\User;
use App\Models\Branch;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Estadísticas principales
        $totalTenants = Tenant::count();
        $activeTenants = Tenant::where('is_active', true)->count();
        $newThisMonth = Tenant::whereMonth('created_at', now()->month)
                            ->whereYear('created_at', now()->year)
                            ->count();
        
        // crecimiento mensual
        $lastMonth = Tenant::whereMonth('created_at', now()->subMonth()->month)
                        ->whereYear('created_at', now()->subMonth()->year)
                        ->count();
        $monthGrowth = $lastMonth > 0 ? round((($newThisMonth - $lastMonth) / $lastMonth) * 100, 1) : 100;

        // Estadísticas de planes
        $planStats = Plan::withCount(['tenants as tenant_count']) 
                        ->get()
                        ->each(function($plan) {
                            $plan->color = $this->getPlanColor($plan->name);
                        });

        // Ingreso mensual estimado
        $monthlyRevenue = $planStats->sum(function($plan) {
            return $plan->price * $plan->tenant_count;
        });

        // Últimas suscripciones
        $recentTenants = Tenant::with('plan')
                            ->latest()
                            ->take(5)
                            ->get();

        // Métricas del sistema
        $totalUsers = User::whereNotNull('tenant_id')->count();
        $totalBranches = Branch::whereNotNull('tenant_id')->count();
        // $storageUsage = $this->calculateStorageUsage();
        // $systemUptime = $this->getSystemUptime();

        return view('dashboard', compact(
            'totalTenants',
            'activeTenants',
            'newThisMonth',
            'monthGrowth',
            'planStats',
            'monthlyRevenue',
            'recentTenants',
            'totalUsers',
            'totalBranches',
            // 'storageUsage',
            // 'systemUptime'
        ));
    }

    private function getPlanColor($planName)
    {
        $colors = [
            'Standard' => 'primary',
            'Premium' => 'success',
            'Enterprise' => 'warning',
            'Enterprise' => 'danger',
            'Personalizado' => 'info'
        ];

        return $colors[$planName] ?? 'secondary';
    }

    private function calculateStorageUsage()
    {
        return '2.5 GB';
    }

    private function getSystemUptime()
    {
        return '99.8%';
    }
}