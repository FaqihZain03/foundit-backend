<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::with(['user', 'location'])->get();
        return response()->json($items);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'location_id' => 'required|exists:locations,id',
            'name' => 'required|max:200',
            'description' => 'nullable|max:500',
            'status' => 'required|in:lost,found,claimed',
            'date_reported' => 'nullable|date',
            'image_url' => 'nullable|max:45',
        ]);

        $item = Item::create($validated);

        return response()->json($item, 201);
    }

    public function show($id)
    {
        $item = Item::with(['user', 'location'])->find($id);
        if (!$item) return response()->json(['message' => 'Item not found'], 404);
        return response()->json($item);
    }

    public function update(Request $request, $id)
    {
        $item = Item::find($id);
        if (!$item) return response()->json(['message' => 'Item not found'], 404);

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'location_id' => 'required|exists:locations,id',
            'name' => 'required|max:200',
            'description' => 'nullable|max:500',
            'status' => 'required|in:lost,found,claimed',
            'date_reported' => 'nullable|date',
            'image_url' => 'nullable|max:45',
        ]);

        $item->update($validated);

        return response()->json($item);
    }

    public function destroy($id)
    {
        $item = Item::find($id);
        if (!$item) return response()->json(['message' => 'Item not found'], 404);
        $item->delete();
        return response()->json(['message' => 'Item deleted']);
    }
}
