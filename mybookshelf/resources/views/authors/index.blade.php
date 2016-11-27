@extends('layouts.app')

@section('title', 'Authors')

@section('content')
<h1>Listing Authors</h1>

<table class='table'>
  <tr>
    <th>Name</th>
    <th>Date of Birth</th>
  </tr>
@foreach($authors as $author)
  <tr>
    <td>{{ $author->name }}</td>
    <td>{{ $author->date_of_birth }}</td>
    <td><a href="/authors/{{ $author->id }}">Edit</a></td>
    <td><a href="/authors/{{ $author->id }}/books">Books</a></td>
  </tr>
@endforeach
</table>
@stop
