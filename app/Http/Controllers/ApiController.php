<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\Post;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function settings() {
        return Settings::first();
    }

    public function store_settings(Request $request) {
        $request->validate([
            "website_title" => "required",
            "website_description" => "required",
        ]);
        if ($settings = Settings::first())
            $settings->fill($request->all())->save();
        else {
            $settings = new Settings($request->all());
            $settings->save();
        }
        
        return response('ok');
    }

    public function featured_posts() {
        return Post::take(5)->with('categories')->get();
    }
}
