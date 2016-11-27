@extends('layouts.app')

@section('title', 'Edit Book')

@section('content')
<h2>Edit Book</h2>

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


<form role="form" method="POST" action="/books/{{ $book->id }}/update">
    <span>ID</span>
    <input class="form-control" type="text" disabled value="{{ $book->id }}"><br/>

    <span>Title</span>
    <input name="title" class="form-control" type="text"
    value="{{ $request->old('title') ?: $book->title }}"><br/>

    <span>Publication Date</span>
    <input name="publication_date" class="form-control datepicker" type="text"
    value="{{ $request->old('publication_date') ?: $book->publication_date }}"><br/>

    <span>ISBN</span>
    <input name="isbn" class="form-control" type="text"
    value="{{ $request->old('isbn') ?: $book->isbn }}"><br/>

    <span>Author</span>
    <select class="form-control" name="author_id">
@foreach($authors as $author)
    @if ($author->id == $book->author_id)
        <option selected value={{ $author->id }}>{{ $author->name }}</option>
    @else
        <option value={{ $author->id }}>{{ $author->name }}</option>
    @endif
@endforeach
    </select><br/>

    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />

    <button type="submit" class="btn btn-default">Save</button>
</form>


<script type="text/javascript">
$('.datepicker').datepicker({
    dateFormat: 'yy-mm-dd'
});
</script>
@stop
