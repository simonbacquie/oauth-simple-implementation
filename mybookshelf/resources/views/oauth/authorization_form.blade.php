@extends('layouts.app')

@section('title', 'Authorize a Third-Party App')

@section('content')

<h2>Authorization Request for {{$client->getName()}}</h2>
<br/>
<p>If you approve, this application will have permission to:</p>
<ul>
@foreach ($params['scope_descriptions'] as $sd)
<li>{{$sd}}</li>
@endforeach
</ul>
<br/>
<form method="post" action="{{route('oauth.authorize.post', $params)}}">
  {{ csrf_field() }}
  
  <input type="hidden" name="client_id" value="{{$params['client_id']}}">
  <input type="hidden" name="redirect_uri" value="{{$params['redirect_uri']}}">
  <input type="hidden" name="response_type" value="{{$params['response_type']}}">
  <input type="hidden" name="state" value="{{$params['state']}}">
  <input type="hidden" name="scope" value="{{$params['scope']}}">

  <button type="submit" name="approve" value="1">Approve</button>
  <button type="submit" name="deny" value="1">Deny</button>
</form>
@stop
