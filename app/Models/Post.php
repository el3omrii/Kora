<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function source() {
        return $this->belongsTo(\App\Models\Source::class);
    }
    public function categories() {
        return $this->belongsToMany(\App\Models\Category::class);
    }
}
