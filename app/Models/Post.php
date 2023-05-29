<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];

    public function source() {
        return $this->belongsTo(\App\Models\Source::class);
    }
    public function categories() {
        return $this->belongsToMany(\App\Models\Category::class);
    }
    public function tags() {
        return $this->belongsToMany(\App\Models\Tag::class);
    }

    protected function getImageAttribute() {
        $settings = \App\Models\Settings::first();
        if ($settings->cdn) {
            return $settings->cdn_url . $this->attributes["image"];
        }
        return $this->attributes["image"];
    }
}
