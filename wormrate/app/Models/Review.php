<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

final class Review extends Model {

  protected $guarded = ['id'];

  public function scopeForCurrentUser($query) {
      return $query->where('user_id', Auth::user()->id);
  }

  public function scopeForBookId($query, $book_id) {
      return $query->where('book_id', $book_id);
  }

  static function reviewedBookIdsForCurrentUser() {
      return array_column(self::forCurrentUser()->get()->toArray(), 'book_id');
  }

}
