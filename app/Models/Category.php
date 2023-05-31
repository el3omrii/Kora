<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $fillable = ["name", "slug", "description", "parent_id"];

    public $timestamps = false;

    public function posts() 
    {
        return $this->belongsToMany(\App\Models\Post::class);
    }
    
    public function sources() 
    {
        return $this->hasMany(\App\Models\Source::class);
    }
    
    public function parent()
    {
        return $this->belongsTo('Category', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('Category', 'parent_id');
    }
}
