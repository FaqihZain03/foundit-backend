<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Claim;
use Illuminate\Http\Request;

class ClaimController extends Controller
{
    public function index()
    {
        return response()->json(Claim::with(['user', 'item'])->get(), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_id' => 'required|exists:items,id',
            'user_id' => 'required|exists:users,id',
            'claim_date' => 'nullable|date',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $claim = Claim::create($validated);
        return response()->json($claim, 201);
    }

    public function show($id)
    {
        $claim = Claim::with(['user', 'item'])->find($id);
        if (!$claim) return response()->json(['message' => 'Claim not found'], 404);
        return response()->json($claim);
    }

    public function update(Request $request, $id)
    {
        $claim = Claim::find($id);
        if (!$claim) return response()->json(['message' => 'Claim not found'], 404);

        $validated = $request->validate([
            'claim_date' => 'nullable|date',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $claim->update($validated);
        return response()->json($claim);
    }

    public function destroy($id)
    {
        $claim = Claim::find($id);
        if (!$claim) return response()->json(['message' => 'Claim not found'], 404);

        $claim->delete();
        return response()->json(['message' => 'Claim deleted']);
    }
}

