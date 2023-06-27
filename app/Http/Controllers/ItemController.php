<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Item;



class ItemController extends Controller
{


    public function index()
    {
        $items = Item::all();

        return response()->json($items);
    }

    public function store(Request $request)
    {

        $validateDate = $this->validateData($request,false);
        $item = new Item;
        $item->fill($validateDate);
        $item->save();

        return response()->json(['message' => 'Item created sucessfully', 'item' => $item], 201);
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

        $validatedData = $this->validateData($request, true);

        $item->fill($validatedData);
        $item->save();


        return response()->json(['message' => 'Item updated successfully', 'item' => $item]);
    }

    public function destroy($id)
    {

    $item = Item::find($id);

    if (!$item) {
        return response()->json(['message' => 'Item not found'], 404);
    }


    $item->delete();


    return response()->json(['message' => 'Item deleted successfully']);

    }



private function validateData(Request $request, $isUpdate = false) {
    $requiredRule = $isUpdate ? 'sometimes' : 'required';

    $request->validate([
        'name' => [
            $requiredRule,
            'min:11',
            function ($attribute, $value, $fail) {
                if (preg_match('/\b(?:Free|Offer|Book|Website)\b/i', $value)) {
                    $fail($attribute.' Ne smije da sadrzi riječi Free, Offer, Book ili Website.');
                }
            },
        ],
        'rating' => [$requiredRule, 'integer', 'min:0', 'max:5'],
        'category' => [$requiredRule, 'string', Rule::in(['hotel', 'alternative', 'hostel', 'guest-house'])],
        'location_id' => [
            $requiredRule,
            Rule::exists('locations', 'id'),
        ],
        'image' => [$requiredRule, 'url'],
        'reputation' => [$requiredRule, 'integer', 'min:0', 'max:1000'],
        'price' => [$requiredRule, 'integer'],
        'availability' => [$requiredRule, 'integer'],
    ]);

    $reputation = $request->reputation;
    $reputationBadge = 'red';
    if ($reputation > 500 && $reputation <= 799) {
        $reputationBadge = 'yellow';
    } elseif ($reputation > 799) {
        $reputationBadge = 'green';
    }

    return array_merge($request->all(), ['reputationBadge' => $reputationBadge]);
}


public function book($id)
{
    $item = Item::find($id);

    if (!$item) {
        return response()->json(['message' => 'Item not found'], 404);
    }

    if ($item->availability <= 0) {
        return response()->json(['message' => 'No availability for this item'], 400);
    }

    $item->availability -= 1;
    $item->save();

    return response()->json(['message' => 'Booking successful', 'item' => $item]);
}

}
