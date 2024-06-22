<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    public function index()
    {
        $admin = Admin::all();
        return response()->json(['admins' => $admins], 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|unique:admins,username|max:255',
            'email' => 'required|string|email|unique:admins,email|max:255',
            'password' => 'required|string|min:8',
            'countrycode' => 'required|string|max:10',
            'mobile_number' => 'required|string|max:20',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        $admin = Admin::create($validatedData);

        return response()->json(['message' => 'Admin created successfully', 'admin' => $admin], 201);
    }

    public function show($id)
    {
        $admin = Admin::find($id);

        if (!$admin) {
            return response()->json(['message' => 'Admin not found'], 404);
        }

        return response()->json(['admin' => $admin], 200);
    }

    public function update(Request $request, $id)
    {
        $admin = Admin::find($id);

        if (!$admin) {
            return response()->json(['message' => 'Admin not found'], 404);
        }

        $validatedData = $request->validate([
            'fullname' => 'sometimes|required|string|max:255',
            'username' => 'sometimes|required|string|unique:admins,username,' . $id . '|max:255',
            'email' => 'sometimes|required|string|email|unique:admins,email,' . $id . '|max:255',
            'password' => 'sometimes|nullable|string|min:8',
            'countrycode' => 'sometimes|required|string|max:10',
            'mobile_number' => 'sometimes|required|string|max:20',
        ]);

        if (isset($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        $admin->update($validatedData);

        return response()->json(['message' => 'Admin updated successfully', 'admin' => $admin], 200);
    }

    public function destroy($id)
    {
        $admin = Admin::find($id);

        if (!$admin) {
            return response()->json(['message' => 'Admin not found'], 404);
        }

        $admin->delete();

        return response()->json(['message' => 'Admin deleted successfully'], 200);
    }
}
