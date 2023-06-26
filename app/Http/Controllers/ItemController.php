<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Item;



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

        $validatedData = $this->validateData($request, false);

        $item = new Item;

        $item->fill($validatedData);
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

        $validatedData = $this->validateData($request, true);

        $item->fill($validatedData);
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

private function validateData(Request $request, $isUpdate = false) {
    $requiredRule = $isUpdate ? 'sometimes' : 'required';

    $request->validate([
        'name' => [
            $requiredRule,
            'min:11',
            function ($attribute, $value, $fail) {
                if (preg_match('/\b(?:Free|Offer|Book|Website)\b/i', $value)) {
                    $fail($attribute.' Ne smije sadržavati riječi Free, Offer, Book ili Website.');
                }
            },
        ],
        'rating' => [$requiredRule, 'integer', 'min:0', 'max:5'],
        'category' => [$requiredRule, 'string', Rule::in(['hotel', 'alternative', 'hostel', 'guest-house'])],
        'location_id' => [$requiredRule, 'exists:locations,id'],
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

}
