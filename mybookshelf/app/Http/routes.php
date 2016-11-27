<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home',               'HomeController@index');

Route::get('/books',              'BookController@index');
Route::get('/books/new',          'BookController@new');
Route::post('/books',             'BookController@create');
Route::get('/books/{id}',         'BookController@edit');
Route::post('/books/{id}/update', 'BookController@update');
Route::get('/authors/{id}/books', 'BookController@by_author');

Route::get('/authors',              'AuthorController@index');
Route::get('/authors/new',          'AuthorController@new');
Route::post('/authors',             'AuthorController@create');
Route::get('/authors/{id}',         'AuthorController@edit');
Route::post('/authors/{id}/update', 'AuthorController@update');

Route::get('oauth/authorize', ['as' => 'oauth.authorize.get', 'uses' => 'OauthController@login_screen']);
Route::post('oauth/authorize', ['as' => 'oauth.authorize.post', 'uses' => 'OauthController@login_submit']);
Route::post('oauth/access_token', function() {
    return Response::json(Authorizer::issueAccessToken());
});

Route::group(['prefix' => 'api', 'before' => 'oauth'], function () {
    Route::get('/books',    ['middleware' => 'oauth:read_books',    'uses' => 'ApiController@books_index']);
    Route::get('/authors',  ['middleware' => 'oauth:read_authors',  'uses' => 'ApiController@authors_index']);
    Route::post('/books',   ['middleware' => 'oauth:write_books',   'uses' => 'ApiController@create_book']);
    Route::post('/authors', ['middleware' => 'oauth:write_authors', 'uses' => 'ApiController@create_author']);
});
