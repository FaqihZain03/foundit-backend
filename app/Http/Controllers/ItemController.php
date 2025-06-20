<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function index()
    {
        return response()->json(Item::with(['user', 'location'])->get(), 200);
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
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image_url')) {
            $image = $request->file('image_url');
            $image->store('items', 'public');
            $validated['image_url'] = $image->hashName();
        }

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
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image_url')) {
            // Delete old image if exists
            if ($item->image_url) {
                Storage::disk('public')->delete('items/' . $item->image_url);
            }

            $image = $request->file('image_url');
            $image->store('items', 'public');
            $validated['image_url'] = $image->hashName();
        }

        $item->update($validated);

        return response()->json($item);
    }

    public function destroy($id)
    {
        $item = Item::find($id);
        if (!$item) return response()->json(['message' => 'Item not found'], 404);

        if ($item->image_url) {
            Storage::disk('public')->delete('items/' . $item->image_url);
        }

        $item->delete();

        return response()->json(['message' => 'Item deleted']);
    }

    

}
