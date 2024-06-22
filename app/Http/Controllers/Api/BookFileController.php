<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\BookFile;
use App\Http\Controllers\Controller;


class BookFileController extends Controller
{
    public function index()
    {
        $books = BookFile::all();
        return response()->json(['books' => $books]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'book_id' => 'required|string|max:255',
            'file' => 'nullable|file',
        ]);

        // Handle file upload if necessary
        // $file = $request->file('file');
        // $filePath = $file->store('books');

        $book = BookFile::create($validatedData);

        return response()->json(['message' => 'Book File created successfully', 'book' => $book], 201);
    }

    public function show($id)
    {
        $book = BookFile::findOrFail($id);
        return response()->json(['book' => $book]);
    }

    public function update(Request $request, $id)
    {
        $book = BookFile::findOrFail($id);

        $validatedData = $request->validate([
            'book_id' => 'required|string|max:255',
            'file' => 'nullable|file',
        ]);

        // Handle file upload if necessary
        // $file = $request->file('file');
        // $filePath = $file->store('books');

        $book->update($validatedData);
 
        return response()->json(['message' => 'Book File updated successfully', 'book' => $book]);
    }

    public function destroy($id)
    {
        $book = BookFile::findOrFail($id);
        $book->delete();

        return response()->json(['message' => 'Book File deleted successfully']);
    }
}
