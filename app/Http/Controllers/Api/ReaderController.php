<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Reader;
use App\Http\Controllers\Controller;

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

        $reader = Reader::create($validatedData);

        return response()->json(['message' => 'Reader created successfully', 'reader' => $reader], 201);
    }

    public function show($id)
    {
        $reader = Reader::findOrFail($id);

        return response()->json(['reader' => $reader], 200);
    }

    public function update(Request $request, $id)
    {
        $reader = Reader::findOrFail($id);

        $validatedData = $request->validate([
            'fullname' => 'sometimes|string|max:255',
            'username' => 'sometimes|string|unique:readers,username,' . $id . '|max:255',
            'email' => 'sometimes|string|email|unique:readers,email,' . $id . '|max:255',
            'password' => 'sometimes|string|min:8',
            'countrycode' => 'sometimes|string|max:10',
            'mobile_number' => 'sometimes|string|max:20',
        ]);

        if (isset($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        $reader->update($validatedData);

        return response()->json(['message' => 'Reader updated successfully', 'reader' => $reader], 200);
    }

    public function destroy($id)
    {
        $reader = Reader::findOrFail($id);
        $reader->delete();

        return response()->json(['message' => 'Reader deleted successfully'], 200);
    }

    
    
    public function login(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
    
        // Return validation errors if any
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
            ], 400);
        }
    
        // Extract data from request
        $credentials = $request->only('username', 'password');
    
        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('YourAppName')->plainTextToken; // Generate token
    
            // Return response with user details and token
            return response()->json([
                'message' => 'Login successful',
                'token' => $token,
                'user' => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'isAdmin' => $user->is_admin,
                ],
            ], 200);
        }
    
        // Authentication failed
        return response()->json([
            'message' => 'Invalid credentials',
        ], 401);
    }
    
    
}
