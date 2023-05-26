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
    public function featured_posts() {
        return Post::take(5)->with('categories')->get();
    }
}
