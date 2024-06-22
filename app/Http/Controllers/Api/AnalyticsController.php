<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Analytics;
use App\Http\Controllers\Controller;

class AnalyticsController extends Controller
{
    public function index()
    {
        $analytics = Analytics::all();
        return response()->json(['analytics' => $analytics], 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'book_id' => 'required|exists:books,id',
            'user_id' => 'required|exists:readers,id',
            'percentage_read' => 'required|numeric|between:0,100',
            'genres' => 'required|in:Fiction,Non-fiction,Fantasy,Sci-fi,Mystery,Romance',
        ]);

        $analytics = Analytics::create($validatedData);

        return response()->json(['message' => 'Analytics data recorded successfully', 'analytics' => $analytics], 201);
    }

    public function show($id)
    {
        $analytics = Analytics::find($id);

        if (!$analytics) {
            return response()->json(['message' => 'Analytics data not found'], 404);
        }

        return response()->json(['analytics' => $analytics], 200);
    }

    public function update(Request $request, $id)
    {
        $analytics = Analytics::find($id);

        if (!$analytics) {
            return response()->json(['message' => 'Analytics data not found'], 404);
        }

        $validatedData = $request->validate([
            'book_id' => 'sometimes|required|exists:books,id',
            'user_id' => 'sometimes|required|exists:readers,id',
            'percentage_read' => 'sometimes|required|numeric|between:0,100',
            'genres' => 'sometimes|required|in:Fiction,Non-fiction,Fantasy,Sci-fi,Mystery,Romance',
        ]);

        $analytics->update($validatedData);

        return response()->json(['message' => 'Analytics data updated successfully', 'analytics' => $analytics], 200);
    }

    public function destroy($id)
    {
        $analytics = Analytics::find($id);

        if (!$analytics) {
            return response()->json(['message' => 'Analytics data not found'], 404);
        }

        $analytics->delete();

        return response()->json(['message' => 'Analytics data deleted successfully'], 200);
    }
}
