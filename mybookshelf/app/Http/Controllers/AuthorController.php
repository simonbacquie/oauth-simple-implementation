<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Author;
use App\Models\Book;

class AuthorController extends Controller
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
        $authors = Author::forCurrentUser()->get();
        return view('authors.index', ['authors' => $authors]);
    }

    public function new(Request $request) {
        return view('authors.new', [
            'request' => $request
        ]);
    }

    public function create(Request $request) {
        $this->validate($request, Author::VALIDATION_RULES);

        $new_author = new Author($request->all());
        $new_author->user_id = Auth::user()->id;
        $new_author->save();

        return redirect('authors/' . $new_author->id);
    }

    public function edit($id, Request $request) {
        $author = Author::where('id', $id)->forCurrentUser()->firstOrFail();

        return view('authors.edit', [
            'request' => $request,
            'author'  => $author,
            'id'      => $id
        ]);
    }

    public function update($id, Request $request) {
        $this->validate($request, Author::VALIDATION_RULES);

        $author = Author::where('id', $id)->forCurrentUser()->firstOrFail();
        $author->update($request->all());

        return redirect('authors/' . $author->id);
    }
}
