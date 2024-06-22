<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\BookFile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class BookFileController extends Controller
{
    public function index()
    {
        $books = BookFile::all();
        return response()->json(['books' => $books], 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'book_id' => 'required|exists:books,id',
            'file' => 'nullable|file|mimes:pdf,epub,doc,docx|max:10240', // File size max 10MB
        ]);

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('book_files', 'public');
            $validatedData['file'] = $filePath;
        }

        $bookFile = BookFile::create($validatedData);

        return response()->json(['message' => 'Book File created successfully', 'book' => $bookFile], 201);
    }

    public function show($id)
    {
        $bookFile = BookFile::find($id);

        if (!$bookFile) {
            return response()->json(['message' => 'Book File not found'], 404);
        }

        return response()->json(['book' => $bookFile], 200);
    }

    public function update(Request $request, $id)
    {
        $bookFile = BookFile::find($id);

        if (!$bookFile) {
            return response()->json(['message' => 'Book File not found'], 404);
        }

        $validatedData = $request->validate([
            'book_id' => 'required|exists:books,id',
            'file' => 'nullable|file|mimes:pdf,epub,doc,docx|max:10240', // File size max 10MB
        ]);

        if ($request->hasFile('file')) {
            if ($bookFile->file) {
                Storage::disk('public')->delete($bookFile->file);
            }
            $filePath = $request->file('file')->store('book_files', 'public');
            $validatedData['file'] = $filePath;
        }

        $bookFile->update($validatedData);

        return response()->json(['message' => 'Book File updated successfully', 'book' => $bookFile], 200);
    }

    public function destroy($id)
    {
        $bookFile = BookFile::find($id);

        if (!$bookFile) {
            return response()->json(['message' => 'Book File not found'], 404);
        }

        if ($bookFile->file) {
            Storage::disk('public')->delete($bookFile->file);
        }

        $bookFile->delete();

        return response()->json(['message' => 'Book File deleted successfully'], 200);
    }
}
