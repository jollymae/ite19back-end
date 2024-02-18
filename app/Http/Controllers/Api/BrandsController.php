<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;

class BrandsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Brand::all();
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string',
            'model_id' => 'required|exists:models,model_id'
        ]);


        // Create the Customer
        $brands = Brand::create([
            'name' => $validatedData['name'],
            'model_id' => $validatedData['model_id'],
        ]);


        // Return the created customer
        return $brands;
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string',
            'model_id' => 'required|exists:models,model_id'
        ]);


        $brands = Brand::findOrFail($id);


        // Update the customer attributes
        $brands->update($validatedData);


        return $brands;
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Logic to retrieve the specific vehicle before deleting it
        $brands = Brand::findOrFail($id);


        // Store the data before deletion
        $deletedData = $brands->toArray();


        // Delete the customer
        $brands->delete();


        // Return the deleted data in the response
        return response()->json(['message' => 'Brand deleted successfully', 'deleted_data' => $deletedData]);
    }
}
