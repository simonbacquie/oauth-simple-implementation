<?php

use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/


$app->get('/', function () use ($app) {
    return $app->welcome();
});

// --- AUTHORS ---

$app->get('/authors', function () use ($app) {
    $authors = Author::all();
    return view('authors.index', ['authors' => $authors]);
});

$app->get('/authors/new', function (Request $request) use ($app) {
  return view('authors.new', [
    'request' => $request
  ]);
});

$app->get('/authors/{id}', function ($id, Request $request) use ($app) {
  $author = Author::find($id);

  return view('authors.edit', [
    'request' => $request,
    'author'  => $author,
    'id'      => $id
  ]);
});

$app->post('/authors', function (Request $request) use ($app) {
  $this->validate($request, Author::VALIDATION_RULES);

  $new_author = new Author($request->all());
  $new_author->save();

  return redirect('authors/' . $new_author->id);
});

$app->post('/authors/{id}/update', function ($id, Request $request) {
  $this->validate($request, Author::VALIDATION_RULES);

  $author = Author::find($id);
  $author->update($request->all());

  return redirect('authors/' . $author->id);
});

// --- BOOKS ---

$app->get('/books', function () use ($app) {
  $books = Book::all();
  return view('books.index', ['books' => $books]);
});

$app->get('/books/new', function (Request $request) use ($app) {
  $authors = Author::all();

  return view('books.new', [
    'authors' => $authors,
    'request' => $request
  ]);
});

$app->post('/books', function (Request $request) use ($app) {
  $this->validate($request, Book::VALIDATION_RULES);
  $new_book = new Book($request->all());
  $new_book->save();

  return redirect('books/' . $new_book->id);
});

$app->get('/books/{id}', function ($id, Request $request) use ($app) {
  $book = Book::find($id);
  $authors = Author::all();

  return view('books.edit', [
    'authors' => $authors,
    'request' => $request,
    'book'    => $book,
    'id'      => $id
  ]);
});

$app->post('/books/{id}/update', function ($id, Request $request) use ($app) {
  $this->validate($request, Book::VALIDATION_RULES);
  $book = Book::find($id);
  $book->update($request->all());

  return redirect('books/' . $book->id);
});

$app->get('authors/{id}/books', function ($id, Request $request) use ($app) {
  $author = Author::find($id);
  $books  = $author->books->all();

  return view('books.by_author', [
    'author'  => $author,
    'request' => $request,
    'books'   => $books,
    'id'      => $id
  ]);

});
