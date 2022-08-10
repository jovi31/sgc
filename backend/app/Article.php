<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{

    protected $fillable = [
        'name', 'description', 'content', 'category_id'
    ];

    protected $casts = [
        'content' => 'string'
    ];
}
