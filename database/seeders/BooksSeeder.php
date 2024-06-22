<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BooksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = [
            [
                'book_name' => 'The Great Gatsby',
                'author' => 'F. Scott Fitzgerald',
                'published_date' => '1925-04-10',
                'book_image' => 'path/to/file1.pdf',
                'genres' => 'fiction',
                'rating' => '4.5',
            ],
            [
                'book_name' => 'To Kill a Mockingbird',
                'author' => 'Harper Lee',
                'published_date' => '1960-07-11',
                'book_image' => 'path/to/file2.pdf',
                'genres' => 'fiction',
                'rating' => '4.8',
            ],
            [
                'book_name' => '1984',
                'author' => 'George Orwell',
                'published_date' => '1949-06-08',
                'book_image' => 'path/to/file3.pdf',
                'genres' => 'fiction',
                'rating' => '4.7',
            ],
            [
                'book_name' => 'Pride and Prejudice',
                'author' => 'Jane Austen',
                'published_date' => '1813-01-28',
                'book_image' => 'path/to/file4.pdf',
                'genres' => 'romance',
                'rating' => '4.6',
            ],
            [
                'book_name' => 'Harry Potter and the Philosopher\'s Stone',
                'author' => 'J.K. Rowling',
                'published_date' => '1997-06-26',
                'book_image' => 'path/to/file5.pdf',
                'genres' => 'fantasy',
                'rating' => '4.9',
            ],
            [
                'book_name' => 'The Catcher in the Rye',
                'author' => 'J.D. Salinger',
                'published_date' => '1951-07-16',
                'book_image' => 'path/to/file6.pdf',
                'genres' => 'fantasy',
                'rating' => '4.4',
            ],
            [
                'book_name' => 'The Hobbit',
                'author' => 'J.R.R. Tolkien',
                'published_date' => '1937-09-21',
                'book_image' => 'path/to/file7.pdf',
                'genres' => 'fantasy',
                'rating' => '4.8',
            ],
            [
                'book_name' => 'The Lord of the Rings',
                'author' => 'J.R.R. Tolkien',
                'published_date' => '1954-07-29',
                'book_image' => 'path/to/file8.pdf',
                'genres' => 'fantasy',
                'rating' => '4.9',
            ],
            [
                'book_name' => 'Brave New World',
                'author' => 'Aldous Huxley',
                'published_date' => '1932-10-27',
                'book_image' => 'path/to/file9.pdf',
                'genres' => 'fantasy',
                'rating' => '4.6',
            ],
            [
                'book_name' => 'The Hitchhiker\'s Guide to the Galaxy',
                'author' => 'Douglas Adams',
                'published_date' => '1979-10-12',
                'book_image' => 'path/to/file10.pdf',
                'genres' => 'fiction',
                'rating' => '4.7',
            ],
        ];

        foreach ($books as $book) {
            DB::table('books')->insert($book);
        }
    }
}
