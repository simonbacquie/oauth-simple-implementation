<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Book;
use App\Models\Review;

use App\MyBookshelfClient;


class BookController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    // Controller Actions

    public function index() {
        // $e = new MyBookshelfClient(Auth::user());
        // $e->activateAuthorizationCode('123');


        $books = Book::all();
        return view('books.index', ['books' => $books]);
    }

    public function show($id, Request $request) {
        $book = Book::where('id', $id)->firstOrFail();
        $reviews = Review::forBookId($id)->get();
        $can_write_review = Review::forBookId($id)->forCurrentUser()->get()->isEmpty();

        return view('books.show', [
            'request' => $request,
            'book'    => $book,
            'reviews' => $reviews,
            'id'      => $id,
            'can_write_review' => $can_write_review
        ]);
    }
}
