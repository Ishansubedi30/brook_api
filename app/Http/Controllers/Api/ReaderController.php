<?php

namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;
use App\Models\Reader;
use App\Http\Controllers\Controller;

class ReaderController extends Controller
{
    public function index()
    {
        $readers = Reader::all();
        return response()->json(['readers' => $readers]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|unique:readers,username',
            'email' => 'required|string|email|unique:readers,email',
            'password' => 'required|string|min:8',
            'countrycode' => 'required|string|max:10',
            'mobile_number' => 'required|string|max:20',
        ]);

        $reader = Reader::create($validatedData);

        return response()->json(['message' => 'Reader created successfully', 'reader' => $reader], 201);
    }

    public function show($id)
    {
        $reader = Reader::findOrFail($id);
        return response()->json(['reader' => $reader]);
    }

    public function update(Request $request, $id)
    {
        $reader = Reader::findOrFail($id);

        $validatedData = $request->validate([
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|unique:readers,username,'.$id,
            'email' => 'required|string|email|unique:readers,email,'.$id,
            'password' => 'nullable|string|min:8',
            'countrycode' => 'required|string|max:10',
            'mobile_number' => 'required|string|max:20',
        ]);

        $reader->update($validatedData);

        return response()->json(['message' => 'Reader updated successfully', 'reader' => $reader]);
    }

    public function destroy($id)
    {
        $reader = Reader::findOrFail($id);
        $reader->delete();

        return response()->json(['message' => 'Reader deleted successfully']);
    }
}
