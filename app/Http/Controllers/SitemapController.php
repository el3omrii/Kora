<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Fixture;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function index() {
        //get posts
        $posts = Post::with('category.parent')->get();
        $tags = Tag::all();
        $categories = Category::all();
        $fixtures = Fixture::all();
        //dd($posts);
        return response()->view('sitemap', [
            'posts' => $posts,
            'tags' => $tags,
            'categories' => $categories,
            'fixtures' => $fixtures
        ])->header('Content-Type', 'text/xml');
    }
}
