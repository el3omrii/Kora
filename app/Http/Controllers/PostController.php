<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Resources\PostResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index() {
        return view("post.index");
    }
    public function create() {
        return view("post.create");
    }
    public function store(Request $request) {
        $request->validate([
            "title" => "required",
            "slug" => "required",
            "categories" => "required"
        ]);
        
        $post = new Post([
            "title" => $request->title,
            "slug" => $request->slug,
            'excerpt' => Str::words($request->content, 20, '(...)'),
            "content" => $request->content,
        ]);
        $post->save();
        //attach categories
        $post->categories()->attach($request->categories);
        //upload
        $folder = \App\Helpers\Helper::createUploadFolder($post);
        if ($file = $request->file("image")) {
            $filename = $file->getClientOriginalName();
            $upload = $file->storeAs($folder, $filename, 'public');
            $post->image = $upload;
        }
        //save
        $post->save();
        return response('ok', 200);
    }
    public function edit(Post $post, Request $request) {
        if ($request->ajax())
            return $post->load('categories')->setHidden(['created_at', 'updated_at']);
        return view("post.edit", compact('post'));
    }
    public function update(Request $request, Post $post) {
        $request->validate([
            "title" => "required",
            "slug" => "required",
        ]);
        
        $post->fill($request->all())->save();
        //attach categories
        if ($request->has('categories')) {
            $post->categories()->detach();
            $post->categories()->attach($request->categories);
        }
        //upload
        $folder = \App\Helpers\Helper::createUploadFolder($post);
        if ($file = $request->file("image")) {
            //remove old pic
            unlink(public_path($post->image));
            $filename = $file->getClientOriginalName();
            $upload = $file->storeAs($folder, $filename, 'public');
            $post->image = $upload;
        }
        //save
        $post->save();
        return response('ok', 200);
    }
    public function destroy (Post $post) 
    {
        // remove records from pivot table category_post
        $post->categories()->detach();
        // remove pic
        Storage::delete($post->image);
        if ($post->delete())
            return response('OK', 200);
        return response('not ok', 500);
    }
    public function categories(Request $request) {
        if ($request->ajax()) {
            return Category::withCount(['sources', 'posts'])->get();
        }
        return view("post.categories");
    }
    public function storeCategory (Request $request) {
        $request->validate([
            "name" => "required|unique:categories|max:255",
        ]);
        Category::create([
            "name" => $request->name,
            "description" => $request->description,
            "parent_id" => $request->parent_id
        ]);
        return response("OK", 200);
    }
    public function updateCategory (Category $category, Request $request) {
        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();
        return response("OK", 200);
    }
    public function destroyCategory (Category $category) {
        if ($category->delete())
            return response("OK", 200);
        return response("Not ok", 500);
    }
    public function fetch(Request $request) {
        $query = Post::orderBy($request->sortBy, $request->sort);
        if($request->q)
            $query = $query->where("title", "like", "%$request->q%");
            
        return PostResource::collection($query->with("categories")->paginate($request->perPage));
    }
}
