<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\Post;
use App\Models\Category;
use App\Http\Resources\PostResource;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function settings() {
        return Settings::first();
    }

    public function stats() {
        return response()->json([
            "posts" => Post::all()->count(),
            "sources" => \App\Models\Source::all()->count(),
            "translations" => \App\Models\Translation::all()->count(),
        ]);
    }

    public function fetch_post(String $slug) {
        $article = Post::where('slug', $slug)->with('source')->firstOrFail();
        $article->related = $article->categories()->first()->posts()->limit(6)->get()->setHidden(['content', 'excerpt']);
        return $article;
    }
    
    public function category_posts(String $slug) {
        //$category = Category::where('slug', $slug);
        $category = Category::first();
	    return PostResource::collection($category->posts()->orderBy('created_at', 'desc')->paginate(12))->additional(['category' => $category]);
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
        return Post::where('featured', true)->latest()->take(5)->with('categories')->get();
    }
    
    public function latest_posts(Request $request) {
        $data = null;
        $limit = $request->has('limit') ? $request->limit : 5;
        if ($request->has('category')) {
            $data = Category::where('id', $request->category)->first()->posts();
            if ($request->has('orderBy'))
                $data->orderBy($request->orderBy, 'desc');
        }
        else
            $data = Post::latest();
        
        return $data->take($limit)->get()->setHidden(['content', 'source_id', 'source_link', 'id']);
    }
}
