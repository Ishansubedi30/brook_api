<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return response()->json(['books' => $books]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'book_name' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'published_date' => 'required|date',
            'file' => 'nullable|file',
            'genres' => 'required|in:Fiction,Non-fiction,Fantasy,Sci-fi,Mystery,Romance',
            'rating' => 'required|numeric|between:0,5',
        ]);

        // Handle file upload if necessary
        // $file = $request->file('file');
        // $filePath = $file->store('books');

        $book = Book::create($validatedData);

        return response()->json(['message' => 'Book created successfully', 'book' => $book], 201);
    }

    public function show($id)
    {
        $book = Book::findOrFail($id);
        return response()->json(['book' => $book]);
    }

    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $validatedData = $request->validate([
            'book_name' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'published_date' => 'required|date',
            'file' => 'nullable|file',
            'genres' => 'required|in:Fiction,Non-fiction,Fantasy,Sci-fi,Mystery,Romance',
            'rating' => 'required|numeric|between:0,5',
        ]);

        // Handle file upload if necessary
        // $file = $request->file('file');
        // $filePath = $file->store('books');

        $book->update($validatedData);

        return response()->json(['message' => 'Book updated successfully', 'book' => $book]);
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return response()->json(['message' => 'Book deleted successfully']);
    }
}
