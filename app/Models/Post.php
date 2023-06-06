<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $hidden = ["pivot"];
    protected $guarded = [];
    protected $appends = ["date"];

    public function source() {
        return $this->belongsTo(\App\Models\Source::class);
    }
    public function category() {
        return $this->belongsTo(\App\Models\Category::class);
    }
    public function tags() {
        return $this->belongsToMany(\App\Models\Tag::class);
    }
    
    protected function getImageAttribute($value) {
        $settings = \App\Models\Settings::first();
        if ($settings->cdn) {
            return $settings->cdn_url . $value;
        }
        return $value;
    }

    protected function getDateAttribute()
    {
        // Parse the created_at field using Carbon and format it
	return Carbon::parse($this->attributes["created_at"])->locale('ar')->diffForHumans(["parts"=>2,"join"=>", "]);//->isoFormat('LL [في] HH:mm');
    }
}
