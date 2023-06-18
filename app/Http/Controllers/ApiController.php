<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\Post;
use App\Models\Category;
use App\Models\Fixture;
use App\Http\Resources\PostResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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

    public function fixtures() {
        return Fixture::latest()->get();
    }
    public function fixture(String $id) {
	    $fixture = Fixture::where("fixture_id", $id)->get();
        $data = cache()->remember("fixture_$id", 3600, function() use ($id) {
            return json_decode(\App\Helpers\Helper::callApi("fixtures?id=$id"));
        });
        return response()->json(["fixture" => $fixture[0], "data" => $data->response[0]]);
    }

    public function fetch_post(String $slug) {
        $article = Post::where('slug', $slug)->with('source', 'category')->firstOrFail();
	$article->related = $article->category->posts()->limit(6)->get()->setHidden(['content', 'pivot', 'source_id', 'source_link']);
	// Check if the post has already been viewed in the current session
	if (!Session::has('viewed_posts.'.$article->id)) {
		$article->increment('views');
		Session::put('viewed_posts.'.$article->id, true);
	}
        return $article;
    }
    
    public function category_posts(Request $request, String $slug) {
        $category = Category::where('slug', $slug)->firstOrFail();
        $orderBy = $request->orderBy;
	    return PostResource::collection($category->posts()->orderBy($orderBy, 'desc')->paginate(12))->additional(['category' => $category]);
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
        return Post::where('featured', true)->latest()->take(5)->with('category.parent')->get();
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
        
        return $data->take($limit)->with('category')->get()->setHidden(['content', 'source_id', 'source_link', 'id']);
    }
}
