@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    You are logged in!
                <br/><br/><br/>

@if ($mybookshelf_enabled)
<h2>MyBookshelf Books To Review</h2><br/>
@foreach ($mb_matching_books as $b)
    @if (!in_array($b->id, $reviewed_book_ids))
        <p><a href='/books/{{ $b->id }}'>{{$b->title}}</a></p>
    @endif
@endforeach
@else
            <p>Do you use MyBookshelf to keep track of the books you own?<br/>You can integrate WormRate to let you know which of your books you have yet to write a review for!</p>
            <a class="btn btn-lg" href="{{ $mybookshelf_login_url }}">Integrate MyBookshelf</a>
@endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
