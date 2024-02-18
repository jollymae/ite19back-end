<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Purchase;


class PurchasesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Purchase::all();
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'inventory_id' => 'required|exists:inventories,inventory_id',
            'customer_id' => 'required|exists:customers,customer_id'
        ]);


        // Create the Customer
        $inventories = Purchase::create([
            'inventory_id' => $validatedData['inventory_id'],
            'customer_id' => $validatedData['customer_id'],
        ]);


        // Return the created customer
        return $inventories;
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'inventory_id' => 'required|exists:inventories,inventory_id',
            'customer_id' => 'required|exists:customers,customer_id'
        ]);


        $inventories = Purchase::findOrFail($id);


        // Update the customer attributes
        $inventories->update($validatedData);


        return $inventories;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Logic to retrieve the specific vehicle before deleting it
        $inventories = Purchase::findOrFail($id);


        // Store the data before deletion
        $deletedData = $inventories->toArray();


        // Delete the customer
        $inventories->delete();


        // Return the deleted data in the response
        return response()->json(['message' => 'Purchase deleted successfully', 'deleted_data' => $deletedData]);
    }
}
