@extends('layouts.app')

@section('title', 'Books')

@section('content')
<h1>Listing Books</h1>

<br/>

<table class='table'>
  <tr>
    <th>Title</th>
    <th>ISBN</th>
    <th>Publication Date</th>
  </tr>
@foreach($books as $book)
  <tr>
    <td>{{ $book->title }}</td>
    <td>{{ $book->isbn }}</td>
    <td>{{ $book->publication_date }}</td>
    <td><a href="/books/{{ $book->id }}">Edit</a></td>
  </tr>
@endforeach
</table>
@stop
