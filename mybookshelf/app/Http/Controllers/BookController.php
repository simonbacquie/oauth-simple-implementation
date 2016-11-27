<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Author;
use App\Models\Book;


class BookController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware(['web', 'auth']);
    }

    // Controller Actions

    public function index() {
        $books = Book::forCurrentUser()->get();

        return view('books.index', ['books' => $books]);
    }

    public function new(Request $request) {
        $authors = Author::forCurrentUser()->get();

        return view('books.new', [
            'authors' => $authors,
            'request' => $request
        ]);
    }

    public function create(Request $request) {
        $this->validate($request, Book::VALIDATION_RULES);
        $new_book = new Book($request->all());
        $new_book->user_id = Auth::user()->id;
        $new_book->save();

        return redirect('books/' . $new_book->id);
    }

    public function edit($id, Request $request) {
        $book = Book::where('id', $id)->forCurrentUser()->firstOrFail();
        $authors = Author::forCurrentUser()->get();

        return view('books.edit', [
            'authors' => $authors,
            'request' => $request,
            'book'    => $book,
            'id'      => $id
        ]);
    }

    public function update($id, Request $request) {
        $this->validate($request, Book::VALIDATION_RULES);
        $book = Book::where('id', $id)->forCurrentUser()->firstOrFail();
        $book->update($request->all());

        return redirect('books/' . $book->id);
    }

    public function by_author($id, Request $request) {
        $author = Author::where('id', $id)->forCurrentUser()->firstOrFail();
        $books  = $author->books()->forCurrentUser()->get();

        return view('books.by_author', [
            'author'  => $author,
            'request' => $request,
            'books'   => $books,
            'id'      => $id
        ]);
    }

}
