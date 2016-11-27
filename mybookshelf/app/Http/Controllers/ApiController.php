<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Author;
use App\Models\Book;
use LucaDegasperi\OAuth2Server\Authorizer;

class ApiController extends Controller {

    public function __construct() {
        // $this->middleware('oauth');
    }

    public function books_index(Authorizer $authorizer) {
        $books = Book::forCurrentUser()->get();
        return json_encode($books);
    }

    public function create_book() {
        $this->validate($request, Book::VALIDATION_RULES);
        $new_book = new Book($request->all());
        $new_book->user_id = Auth::user()->id;
        $new_book->save();

        return json_encode($new_book);
    }

    public function authors_index() {
        $authors = Author::forCurrentUser()->get();
        return json_encode($authors);
    }

    public function create_author() {
        $this->validate($request, Author::VALIDATION_RULES);
        $new_author = new Author($request->all());
        $new_author->user_id = Auth::user()->id;
        $new_author->save();

        return json_encode($new_author);
    }

}
