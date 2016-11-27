@extends('layouts.app')

@section('title', 'Books')

@section('content')
<h1>Listing Books</h1>

<br/>

<table class='table'>
  <tr>
    <th>ISBN</th>
    <th>Title</th>
    <th>Author</th>
  </tr>
@foreach($books as $book)
  <tr>
    <td>{{ $book->id }}</td>
    <td>{{ $book->title }}</td>
    <td>{{ $book->author }}</td>
    <td><a href="/books/{{ $book->id }}">See Ratings</a></td>
  </tr>
@endforeach
</table>
@stop
