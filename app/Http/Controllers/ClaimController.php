<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use Illuminate\Http\Request;

class ClaimController extends Controller
{
    public function index()
    {
        $claims = Claim::with(['user', 'item'])->get();

        return response()->json([
            'success' => true,
            'message' => 'Get all claims',
            'data' => $claims
        ], 200);
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

        return response()->json([
            'success' => true,
            'message' => 'Claim created successfully',
            'data' => $claim
        ], 201);
    }

    public function show($id)
    {
        $claim = Claim::with(['user', 'item'])->find($id);

        if (!$claim) {
            return response()->json([
                'success' => false,
                'message' => 'Claim not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Get claim detail',
            'data' => $claim
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $claim = Claim::find($id);

        if (!$claim) {
            return response()->json([
                'success' => false,
                'message' => 'Claim not found'
            ], 404);
        }

        $validated = $request->validate([
            'claim_date' => 'nullable|date',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $claim->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Claim updated successfully',
            'data' => $claim
        ], 200);
    }

    public function destroy($id)
    {
        $claim = Claim::find($id);

        if (!$claim) {
            return response()->json([
                'success' => false,
                'message' => 'Claim not found'
            ], 404);
        }

        $claim->delete();

        return response()->json([
            'success' => true,
            'message' => 'Claim deleted successfully'
        ], 200);
    }

    
}
