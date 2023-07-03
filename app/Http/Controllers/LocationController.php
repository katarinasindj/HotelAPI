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
        $validateData = $this->validateData($request, false);

        $location = new Location;
        $location->fill($validateData);
        $location->save();

        return response()->json($location,201);

    }

    public function show($id)
    {
        $location = Location::find($id);
        if ($location) {
            return response()->json($location);
        } else {
            return response()->json(['message' => "Location not found "], 404);
        }
    }

    public function update (Request $request, $id)

    {
        $validateData = $this->validateData($request, true);


        $location = Location::find($id);
        if (!$location) {
            return response()->json(['message' => 'Location not found'], 404);
        }

        $location->fill($validateData);
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

    private function validateData(Request $request, $isUpdate = false)
    {
        $requiredRule = $isUpdate ? 'sometimes' : 'required';

        $request->validate([
            'city' => [$requiredRule, 'string'],
            'state' => [$requiredRule, 'string'],
            'country' => [$requiredRule, 'string'],
            'zip_code' => [$requiredRule, 'integer', 'digits:5'],
            'state' => [$requiredRule, 'string']

        ]);

        return $request->all();
    }

}
