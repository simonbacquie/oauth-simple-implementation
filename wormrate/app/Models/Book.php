<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

final class Book extends Model {

  protected $guarded = ['id'];

  public function scopeMatchingMyBookshelfBooks($query, $mb_books) {
      $mb_isbn_numbers = array_column((array)$mb_books, 'isbn');
      return $query->whereIn('id', $mb_isbn_numbers);
  }

}
