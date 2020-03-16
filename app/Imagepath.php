<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Imagepath extends Model
{
    protected $fillable = ['src', 'alt', 'post_id', 'rotation'];

    public function post() {
        return $this->belongsTo('App\Post');
    }
}
