<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehicle;
use Illuminate\Support\Facades\DB;

class VehiclesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = DB::table("vehicles")
            ->join("models", "vehicles.model_id", "=", "models.model_id")
            ->join("brands", "models.model_id", "=", "brands.brand_id")
            ->join("options", "models.model_id", "=", "options.option_id")
            ->join("inventories", "vehicles.vehicle_id", "=", "inventories.inventory_id")


            ->select(
                "VIN",
                "body_style",
                "options.color",
                "options.transmission",
                "options.engine",
                "inventories.price",
                DB::raw('models.name as model_name'),
                DB::raw('brands.name as brand_name'),
            )
            ->get();
        return $data;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'VIN' => 'required|string',
            'model_id' => 'required|exists:models,model_id',
            'dealer_id' => 'required|exists:dealers,dealer_id'
        ]);


        // Create the Customer
        $vehicles = Vehicle::create([
            'VIN' => $validatedData['VIN'],
            'model_id' => $validatedData['model_id'],
            'dealer_id' => $validatedData['dealer_id'],
        ]);


        // Return the created customer
        return $vehicles;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        // Validate the request data
        $validatedData = $request->validate([
            'VIN' => 'required|string',
            'model_id' => 'required|exists:models,model_id',
            'dealer_id' => 'required|exists:dealers,dealer_id'
        ]);


        $vehicles = Vehicle::findOrFail($id);


        // Update the customer attributes
        $vehicles->update($validatedData);


        return $vehicles;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Logic to retrieve the specific vehicle before deleting it
        $vehicles = Vehicle::findOrFail($id);


        // Store the data before deletion
        $deletedData = $vehicles->toArray();


        // Delete the customer
        $vehicles->delete();


        // Return the deleted data in the response
        return response()->json(['message' => 'Vehicle deleted successfully', 'deleted_data' => $deletedData]);
    }
}
