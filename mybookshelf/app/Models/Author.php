<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

final class Author extends Model {

  const VALIDATION_RULES = [
    'name'          => 'required',
    'date_of_birth' => 'required|date'
  ];

  protected $fillable = ['name', 'date_of_birth'];

  public function books() {
      return $this->hasMany('App\Models\Book');
  }

  public function scopeForCurrentUser($query) {
      return $query->where('user_id', Auth::user()->id);
  }

}
