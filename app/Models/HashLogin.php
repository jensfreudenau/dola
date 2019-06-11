<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HashLogin extends Model
{
    protected $fillable = ['email', 'hash', 'active'];
}
