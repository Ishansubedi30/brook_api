<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Reader;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class ReaderController extends Controller
{
    public function index()
    {
        $readers = Reader::all();
        return response()->json(['readers' => $readers], 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|unique:readers,username|max:255',
            'email' => 'required|string|email|unique:readers,email|max:255',
            'password' => 'required|string|min:8',
            'countrycode' => 'required|string|max:10',
            'mobile_number' => 'required|string|max:20',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        $readers = Reader::create($validatedData);

        return response()->json(['message' => 'Reader created successfully', 'readers' => $readers], 201);
    }

    public function show($id)
    {
        $readers = Reader::find($id);

        if (!$readers) {
            return response()->json(['message' => 'Reader not found'], 404);
        }

        return response()->json(['readers' => $readers], 200);
    }

    public function update(Request $request, $id)
    {
        $readers = Reader::find($id);

        if (!$readers) {
            return response()->json(['message' => 'Reader not found'], 404);
        }

        $validatedData = $request->validate([
            'fullname' => 'sometimes|required|string|max:255',
            'username' => 'sometimes|required|string|unique:readers,username,' . $id . '|max:255',
            'email' => 'sometimes|required|string|email|unique:readers,email,' . $id . '|max:255',
            'password' => 'sometimes|nullable|string|min:8',
            'countrycode' => 'sometimes|required|string|max:10',
            'mobile_number' => 'sometimes|required|string|max:20',
        ]);

        if (isset($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        $readers->update($validatedData);

        return response()->json(['message' => 'Reader updated successfully', 'readers' => $readers], 200);
    }

    public function destroy($id)
    {
        $readers = Reader::find($id);

        if (!$readers) {
            return response()->json(['message' => 'Reader not found'], 404);
        }

        $readers->delete();

        return response()->json(['message' => 'Reader deleted successfully'], 200);
    }
}
