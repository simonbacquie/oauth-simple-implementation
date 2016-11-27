@extends('layouts.app')

@section('title', 'New Author')

@section('content')
<h2>New Author</h2>

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

<form role="form" method="POST" action="/authors">
  <span>Name</span>
  <input name="name" class="form-control" type="text" value="{{ $request->old('name') }}"><br/>

  <span>Date of Birth</span>
  <input name="date_of_birth" class="form-control datepicker" type="text" value="{{ $request->old('date_of_birth') }}"><br/>

  <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />

  <button type="submit" class="btn btn-default">Save</button>
</form>

<script type="text/javascript">
$('.datepicker').datepicker({
  dateFormat: 'yy-mm-dd'
});
</script>
@stop
