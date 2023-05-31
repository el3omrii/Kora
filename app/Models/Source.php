<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    use HasFactory;

    public $fillable = ['name', 'feed_url', 'description', 'content_regex', 'image_type', 'logo', 'category_id'];

    public function posts() {
        return $this->hasMany(\App\Models\Post::class);
    }

    public function category() {
        return $this->belongsTo(\App\Models\Category::class);
    }

    protected function getLogoAttribute($value) {
        $settings = \App\Models\Settings::first();
        if ($settings->cdn) {
            return $settings->cdn_url .'/'. $value;
        }
        return $value;
    }
}
