<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OriginalToken extends Model
{
    protected $fillable = ['personal_access_token_id', 'token'];

//    public $timestamps = false;
}
