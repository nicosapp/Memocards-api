<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserVerification extends Model
{
    protected $fillable = [
        'token',
        'tentative'
    ];

    public function user(){
        return $this->hasOne(User::class);
    }
}
