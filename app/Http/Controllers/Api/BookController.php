<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\BookResource;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::get();
        if($books->count()>0){
        return BookResource::collection($books);
        }else{
            return response()->json(['message'=>'No Record Available'],200);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'book_name' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'published_date' => 'required|date',
            'book_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'genres' => 'required|in:Fiction,Non-fiction,Fantasy,Sci-fi,Mystery,Romance',
            'rating' => 'required|numeric|between:0,5',
        ]);

        if ($validator->fails()){
            return response()->json(['message' => 'Something Went Wrong, Try Again!', 
            'error'=> $validator->messages(),
        422]);
        }
        
        if ($request->hasFile('book_image')) {
            $filePath = $request->file('book_image')->store('books', 'public');
            $validator['book_image'] = $filePath;
        }

        $book = Book::create([
            'book_name' => $request->book_name,
            'author' => $request->author,
            'published_date' => $request->published_date,
            'book_image' => $request->book_image,
            'genres' => $request->genres,
            'rating' => $request->rating,
        ]);

        return response()->json(['message' => 'Book Added Successfully', 
        'data' =>new BookResource($book)], 
        200);
    }

    public function show($id)
    {
        $book = Book::find($id);
    
        if (!$book) {
            return response()->json([
                'error' => 'Book not found',
            ], 404);
        }
    
        return new BookResource($book);
    }
    
    public function update(Request $request, $id)
    {
        // Find the book by ID
        $book = Book::find($id);
    
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }
    
        // Validate the request data
        $validator = $request->validate([
            'book_name' => 'nullable|string|max:255',
            'author' => 'nullable|string|max:255',
            'published_date' => 'nullable|date',
            'book_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'genres' => 'nullable|in:Fiction,Non-fiction,Fantasy,Sci-fi,Mystery,Romance',
            'rating' => 'nullable|numeric|between:0,5',
        ]);
    
        // Check if there's a new book image file in the request
        if ($request->hasFile('book_image')) {
            // Delete the old book image if it exists
            if ($book->book_image) {
                Storage::disk('public')->delete($book->book_image);
            }
    
            // Store the new book image and update the file path in the validator array
            $filePath = $request->file('book_image')->store('books', 'public');
            $validator['book_image'] = $filePath;
        }
    
        // Update the book with the validated data
        $book->update($validator);
    
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
