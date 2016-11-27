<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Book;
use App\Models\Review;


class ReviewController extends Controller
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

    public function create($book_id, Request $request) {
        $new_review = new Review($request->all());
        $new_review->user_id = Auth::user()->id;
        $new_review->book_id = $book_id;
        $new_review->save();

        return redirect('books/' . $book_id);
    }

    // public function by_author($id, Request $request) {
    //     $author = Author::where('id', $id)->forCurrentUser()->firstOrFail();
    //     $books  = $author->books()->forCurrentUser()->get();
    //
    //     return view('books.by_author', [
    //         'author'  => $author,
    //         'request' => $request,
    //         'books'   => $books,
    //         'id'      => $id
    //     ]);
    // }

}
