<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\MyBookshelfClient;
use App\Models\Book;
use App\Models\Review;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $mybookshelf_enabled = !empty(Auth::user()->mybookshelf_access_token);

        $mb_books          = null;
        $reviewed_book_ids = null;
        $mb_matching_books = null;
        if ($mybookshelf_enabled) {
            $mb_client = new MyBookshelfClient(Auth::user());
            $mb_books  = $mb_client->getBooksForUser();
            $mb_matching_books = Book::matchingMyBookshelfBooks($mb_books)->get();
            $reviewed_book_ids = Review::reviewedBookIdsForCurrentUser();
        }

        return view('home', [
            'mybookshelf_login_url' => MyBookshelfClient::loginScreenUrl(),
            'mybookshelf_enabled'   => $mybookshelf_enabled,
            'mb_books'              => $mb_books,
            'mb_matching_books'     => $mb_matching_books,
            'reviewed_book_ids'     => $reviewed_book_ids,
        ]);
    }

    public function mybookshelf(Request $request) {
        $client = new MyBookshelfClient(Auth::user());
        $client->activateAuthorizationCode($request->get('code'));
        return view('mybookshelf_success');
    }
}
