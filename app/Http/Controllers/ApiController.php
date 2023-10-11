<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Fixture;
use App\Http\Resources\PostResource;
use Carbon\Carbon;
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
        return Fixture::whereDate('date', Carbon::today())->orderBy('date')->get();
    }
    public function fixture(String $id) {
	    $fixture = Fixture::where("fixture_id", $id)->first();
        $data = cache()->remember("fixture_$id", 600, function() use ($id) {
            return json_decode(\App\Helpers\Helper::callApi("fixtures?id=$id"));
        });
        $fixture->fixture_data = $data->response[0];
        $fixture->save();
        return response()->json(["fixture" => $fixture, "data" => $data->response[0]]);
    }
    
    public function fixture_lineup(String $id) {
	    $fixture = Fixture::where("fixture_id", $id)->first();
        $date = Carbon::parse($fixture->date);
        if (Carbon::now()->diffInMinutes($date, false) > 20)
            return response()->json(["error:" => "not available yet, try again later .."]);
        $data = cache()->remember("lineup_fixture_$id", 3600 * 12, function() use ($id) {
            return json_decode(\App\Helpers\Helper::callApi("fixtures/lineups?fixture=$id"));
        });
        if (!$data->response)
            return response()->json(["error:" => "not available yet, try again later .."]);
        else 
            return response()->json(["data" => $data->response]);
            
    }

    public function fetch_post(String $slug) {
        $article = Post::where('slug', $slug)->with('source', 'category.parent', 'tags')->firstOrFail();
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
	    return PostResource::collection($category->getAllPosts()->orderBy($orderBy, 'desc')->paginate(12))->additional(['category' => $category]);
    }
    public function tag_posts(Request $request, String $slug) {
        $tag = Tag::where('slug', $slug)->firstOrFail();
        $orderBy = $request->orderBy;
	    return PostResource::collection($tag->posts()->with('category')->orderBy($orderBy, 'desc')->paginate(12))->additional(['tag' => $tag]);
    }
    public function popular_tags() {
        return Tag::withCount('posts')->orderBy('posts_count')->limit(10)->get();
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
        $latestPosts = null;
        $limit = $request->has('limit') ? $request->limit : 5;
        if ($request->has('category')) {
            $category = Category::with('children.posts')->find($request->category);
            if (!$category) {
                return response()->json(['message' => 'Category not found'], 404);
            }
            $latestPosts = $category->posts()
                ->orWhereIn('category_id', $category->children->pluck('id'));
            if ($request->has('orderBy'))
                $latestPosts = $latestPosts->orderBy($request->orderBy, 'desc');
        }
        else
            $latestPosts = Post::latest();
        
        return $latestPosts->take($limit)->with('category')->get()->setHidden(['content', 'source_id', 'source_link', 'id']);
    }
}
