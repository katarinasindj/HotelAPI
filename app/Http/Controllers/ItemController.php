<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Retrieve all items from the 'items' table
        $items = Item::all();

        // Return the items as a JSON response
        return response()->json($items);
    }

    // Ovde možete dodati i druge metode, kao što su create(), store(), show($id), update(), destroy($id), etc.
}
