<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

final class Book extends Model {

  const VALIDATION_RULES = [
    'title'            => 'required',
    'publication_date' => 'required|date',
    'isbn'             => 'required|string|size:13',
    'author_id'        => 'required|integer'
  ];

  protected $guarded = ['id'];

  public function scopeForCurrentUser($query) {
      // get the user ID, whether it's through the user login or through OAuth
      $user_id = (Auth::user()) ? Auth::user()->id : Authorizer::getResourceOwnerId();
      return $query->where('user_id', $user_id);
  }

}
