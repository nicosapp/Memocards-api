<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
  protected $fillable = [
    'name',
    'email',
    'password',
    'slug'
  ];

  public function user()
  {
    return $this->hasOne(User::class);
  }
}
