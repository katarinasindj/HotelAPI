<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{

    public function index()
    {
        // Uzima sve item-e iz tabele items
        $items = Item::all();

        // Vraca items kao JSON response
        return response()->json($items);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'rating' => 'required',
            'category' => 'required',
            'location_id' => 'required',
            'image' => 'required',
            'reputation' => 'required',
            'reputationBadge' => 'required',
            'price' => 'required',
            'availability' => 'required',


        ]);

        $item = new Item;
        $item->name = $request->name;
        $item->rating = $request->rating;
        $item->category = $request->category;
        $item->location_id = $request->location_id;
        $item->image = $request->image;
        $item->reputation = $request->reputation;
        $item->reputationBadge = $request->reputationBadge;
        $item->price = $request->price;
        $item->availability = $request->availability;

        $item->save();

        return response()->json(['message' => 'Item created successfully', 'item' => $item], 201);
    }

    public function show($id)
    {
        $item = Item::find($id);

        if($item) {
           return response()->json($item);
        } else {
            return response()->json(['message' => 'Item not found'], 404);
        }
    }
    public function update(Request $request, $id)
    {

        $item = Item::find($id);

        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        // Validacija podataka iz zahtijeva
        $request->validate([
            'name' => 'required',
            'rating' => 'required',
            'category' => 'required',
            'location_id' => 'required',
            'image' => 'required',
            'reputation' => 'required',
            'reputationBadge' => 'required',
            'price' => 'required',
            'availability' => 'required'
        ]);


        $item->name = $request->name;
        $item->rating = $request->rating;
        $item->category = $request->category;
        $item->location_id = $request->location_id;
        $item->image = $request->image;
        $item->reputation = $request->reputation;
        $item->reputationBadge = $request->reputationBadge;
        $item->price = $request->price;
        $item->availability = $request->availability;

        $item->save();


        return response()->json(['message' => 'Item updated successfully', 'item' => $item]);
    }

    public function destroy($id)
{
    // Pokušavamo da pronađemo stavku sa zadatim ID-em
    $item = Item::find($id);

    // Ako stavka nije pronađena, vraćamo odgovor sa statusom 404
    if (!$item) {
        return response()->json(['message' => 'Item not found'], 404);
    }


    $item->delete();


    return response()->json(['message' => 'Item deleted successfully']);
}


}




