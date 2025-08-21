<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class EventController extends Controller
{
    // List event dengan pagination + filter + sort + cache
    public function index(Request $request)
    {
        $cacheKey = 'events_' . md5(json_encode($request->all()));

        $events = Cache::remember($cacheKey, 30, function () use ($request) {
            $query = Event::query();

            // Filter status
            if ($request->has('status')) {
                $query->where('status', $request->status);
            }

            // Sort (default by created_at)
            $sortBy = $request->get('sort_by', 'created_at');
            $sortOrder = $request->get('sort_order', 'desc');
            $query->orderBy($sortBy, $sortOrder);

            return $query->paginate($request->get('per_page', 10));
        });

        return response()->json([
            'success' => true,
            'data' => $events
        ]);
    }

    // Detail event
    public function show($id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json(['success' => false, 'message' => 'Event not found'], 404);
        }

        return response()->json(['success' => true, 'data' => $event]);
    }

    // Create event (RBAC: only organizer & admin)
    public function store(Request $request)
    {
        if (!in_array(Auth::user()->role, ['admin', 'organizer'])) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'venue' => 'required|string',
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after:start_datetime',
            'status' => 'required|in:draft,published'
        ]);

        $validated['organizer_id'] = Auth::id();

        $event = Event::create($validated);

        // Invalidate cache
        Cache::flush();

        return response()->json(['success' => true, 'message' => 'Event created', 'data' => $event], 201);
    }

    // Update event (RBAC: only owner or admin)
    public function update(Request $request, $id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json(['success' => false, 'message' => 'Event not found'], 404);
        }

        if (Auth::user()->role !== 'admin' && $event->organizer_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Forbidden'], 403);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'venue' => 'sometimes|required|string',
            'start_datetime' => 'sometimes|required|date',
            'end_datetime' => 'sometimes|required|date|after:start_datetime',
            'status' => 'sometimes|required|in:draft,published'
        ]);

        $event->update($validated);

        // Invalidate cache
        Cache::flush();

        return response()->json(['success' => true, 'message' => 'Event updated', 'data' => $event]);
    }

    //Delete event (RBAC: only owner or admin)
    public function destroy($id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json(['success' => false, 'message' => 'Event not found'], 404);
        }

        if (Auth::user()->role !== 'admin' && $event->organizer_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Forbidden'], 403);
        }

        $event->delete();

        // Invalidate cache
        Cache::flush();

        return response()->json(['success' => true, 'message' => 'Event deleted']);
    }
}
