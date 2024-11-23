<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::all(); // Get all suppliers to pass to the view
        return view('layout', compact('suppliers'));
    }
 
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("master-data.supplier-master.create-supplier");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'name' => 'required|string|max:255', 
            'phone' => 'required|string|max:50', 
            'address' => 'nullable|string',
            'comment' => 'required|string|max:255',
        ]);
        
        // Process saving data to the database
        Supplier::create($validated_data);
        
        return redirect()->back()->with('success', 'Supplier created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Implement show logic
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Implement edit logic
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Implement update logic
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Implement destroy logic
    }
}
