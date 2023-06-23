<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::all();
        return response()->json($locations);
    }

    public function store (Request $request)
    {
        $location = new Location;
        $location->city = $request->input('city');
        $location->state = $request->input('state');
        $location->country = $request->input('country');
        $location->zip_code = $request->input('zip_code');
        $location->address = $request->input('address');
        $location->save();

        return response()->json($location,201);

    }

    public function show($id)
    {
        $location = Location::find($id);
        if (!$location) {
            return response()->json(['message' => 'Location not found'], 404);
        }
        return response()->json($location);
    }

    public function update (Request $request, $id)

    {
        $location = Location::find($id);
        if (!$location) {
            return response()->json(['message' => 'Location not found'], 404);
        }

        $location->city = $request->input('city', $location->city);
        $location->state = $request->input('state', $location->state);
        $location->country = $request->input('country', $location->country);
        $location->zip_code = $request->input('zip_code', $location->zip_code);
        $location->address = $request->input('address', $location->address);
        $location->save();

        return response()->json($location);
    }

    public function destroy($id)
    {
        $location = Location::find($id);
        if (!$location) {
            return response()->json(['message'=> 'Location not found'],404);
        }
        $location->delete();

        return response()->json(['message' => 'Location deleted successfully']);
    }

}