<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::all();
        return view('plans.index',compact('plans'));
    }

    public function create()
{
    return view('plans.create');
}

public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'limit_users' => 'required|integer|min:1'
    ]);

    Plan::create($validated);

    return redirect()->route('plans.index')
        ->with('success', 'Plan creado correctamente.');
}
    
    public function edit($id)
{
    $plan = Plan::findOrFail($id);
    return view('plans.edit', compact('plan'));
}

public function update(Request $request, $id)
{
    $plan = Plan::findOrFail($id);
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'limit_users' => 'required|integer|min:1'
    ]);

    $plan->update($validated);

    return redirect()->route('plans.index')
        ->with('success', 'Plan actualizado correctamente.');
}

    public function destroy($id)
    {
        
            $plan = Plan::findOrFail($id);
            $plan->delete();
            
            return redirect()->route('plans.index')->with('success', 'Plan eliminado correctamente.');
        
    }
}
