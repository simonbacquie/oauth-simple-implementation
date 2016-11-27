@extends('layouts.app')

@section('title', 'Book Reviews')

@section('content')
<h2>{{$book->title}}</h2>
<h3>by {{$book->author}}</h3>
<h4>ISBN {{$book->id}}</h4>

<br/>

@if (!empty($errors->all()))
<div class="alert alert-danger fade in">
    <a href="#" class="close" data-dismiss="alert">&times;</a>
    <strong>Record could not be saved:</strong>
    <ul>
@foreach($errors->all() as $error)
        <li>{{ $error }}</li>
@endforeach
    </ul>
</div>
@endif


@if ($can_write_review)
<h2>Review This Book</h2>
<form role="form" method="POST" action="/books/{{ $book->id }}/reviews">
    <span>Star Rating:</span><br/>
      <input type="radio" name="rating" value="1"> 1&nbsp;&nbsp;&nbsp;
      <input type="radio" name="rating" value="2"> 2&nbsp;&nbsp;&nbsp;
      <input type="radio" name="rating" value="3"> 3&nbsp;&nbsp;&nbsp;
      <input type="radio" name="rating" value="4"> 4&nbsp;&nbsp;&nbsp;
      <input type="radio" name="rating" value="5"> 5<br/><br/>

    <span>Review</span>
    <textarea name="review" class="form-control" type="text"
    value="{{ $request->old('review') ?: '' }}"></textarea><br/>

    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />

    <button type="submit" class="btn btn-default">Submit</button>
</form>
@else
<p>You have already written a review for this book.</p>
@endif

<h2>Reviews</h2><br/>
@foreach($reviews as $review)
<div>
        <p><strong>Stars:</strong> {{ $review->rating }}</p>
        <p>{{ $review->review }}</p>
        <hr/>
</div>
@endforeach

@if ($reviews->isEmpty())
<p>There are no reviews for this book. Write one yourself!</p>
@endif

@stop
