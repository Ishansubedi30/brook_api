<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Analytics;

class AnalyticsController extends Controller
{
    public function index()
    {
        $analytics = Analytics::all();
        return response()->json(['analytics' => $analytics]);
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
        $analytics = Analytics::findOrFail($id);
        return response()->json(['analytics' => $analytics]);
    }

    public function update(Request $request, $id)
    {
        $analytics = Analytics::findOrFail($id);

        $validatedData = $request->validate([
            'book_id' => 'required|exists:books,id',
            'user_id' => 'required|exists:readers,id',
            'percentage_read' => 'required|numeric|between:0,100',
            'genres' => 'required|in:Fiction,Non-fiction,Fantasy,Sci-fi,Mystery,Romance',
        ]);

        $analytics->update($validatedData);

        return response()->json(['message' => 'Analytics data updated successfully', 'analytics' => $analytics]);
    }

    public function destroy($id)
    {
        $analytics = Analytics::findOrFail($id);
        $analytics->delete();

        return response()->json(['message' => 'Analytics data deleted successfully']);
    }
}
