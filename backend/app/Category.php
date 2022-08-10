<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    public $timestamps = false;

    protected $fillable = ['name', 'parent_id'];

    protected $attributes = [
        'parent_id' => null
    ];

    public function parent()
    {
        return $this->belongsTo('App\Category', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('App\Category', 'parent_id');
    }
    
    // simples
    // public function child()
    // {
    //     return $this->hasMany('App\Category', 'parent_id')->with('child');
    // }
}
