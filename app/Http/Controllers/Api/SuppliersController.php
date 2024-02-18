<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;

class SuppliersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Supplier::all();
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string',
        ]);


        // Create the Customer
        $suppliers = Supplier::create([
            'name' => $validatedData['name'],
        ]);


        // Return the created customer
        return $suppliers;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string',
        ]);


        $suppliers = Supplier::findOrFail($id);


        // Update the customer attributes
        $suppliers->update($validatedData);


        return $suppliers;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Logic to retrieve the specific vehicle before deleting it
        $suppliers = Supplier::findOrFail($id);


        // Store the data before deletion
        $deletedData = $suppliers->toArray();


        // Delete the customer
        $suppliers->delete();


        // Return the deleted data in the response
        return response()->json(['message' => 'Supplier deleted successfully', 'deleted_data' => $deletedData]);
    }
}
