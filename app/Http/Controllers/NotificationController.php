<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        return response()->json(Notification::with('user')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'messages' => 'required|string',
            'is_read' => 'in:yes,no',
        ]);

        $notification = Notification::create($validated);
        return response()->json($notification, 201);
    }

    public function show($id)
    {
        $notification = Notification::with('user')->find($id);
        if (!$notification) return response()->json(['message' => 'Notification not found'], 404);
        return response()->json($notification);
    }

    public function update(Request $request, $id)
    {
        $notification = Notification::find($id);
        if (!$notification) return response()->json(['message' => 'Notification not found'], 404);

        $validated = $request->validate([
            'messages' => 'sometimes|required|string',
            'is_read' => 'required|in:yes,no',
        ]);

        $notification->update($validated);
        return response()->json($notification);
    }

    public function destroy($id)
    {
        $notification = Notification::find($id);
        if (!$notification) return response()->json(['message' => 'Notification not found'], 404);

        $notification->delete();
        return response()->json(['message' => 'Notification deleted']);
    }
}

