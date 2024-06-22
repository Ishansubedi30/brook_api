<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return response()->json(['books' => $books], 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'book_name' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'published_date' => 'required|date',
            'book_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'genres' => 'required|in:Fiction,Non-fiction,Fantasy,Sci-fi,Mystery,Romance',
            'rating' => 'required|numeric|between:0,5',
        ]);

        if ($request->hasFile('book_image')) {
            $filePath = $request->file('book_image')->store('books', 'public');
            $validatedData['book_image'] = $filePath;
        }

        $book = Book::create($validatedData);

        return response()->json(['message' => 'Book created successfully', 'book' => $book], 201);
    }

    public function show($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        return response()->json(['book' => $book], 200);
    }

    public function update(Request $request, $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        $validatedData = $request->validate([
            'book_name' => 'sometimes|required|string|max:255',
            'author' => 'sometimes|required|string|max:255',
            'published_date' => 'sometimes|required|date',
            'book_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'genres' => 'sometimes|required|in:Fiction,Non-fiction,Fantasy,Sci-fi,Mystery,Romance',
            'rating' => 'sometimes|required|numeric|between:0,5',
        ]);

        if ($request->hasFile('book_image')) {
            if ($book->book_image) {
                Storage::disk('public')->delete($book->book_image);
            }
            $filePath = $request->file('book_image')->store('books', 'public');
            $validatedData['book_image'] = $filePath;
        }

        $book->update($validatedData);

        return response()->json(['message' => 'Book updated successfully', 'book' => $book], 200);
    }

    public function destroy($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        if ($book->book_image) {
            Storage::disk('public')->delete($book->book_image);
        }

        $book->delete();

        return response()->json(['message' => 'Book deleted successfully'], 200);
    }
}
