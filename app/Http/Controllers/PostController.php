<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Resources\PostResource;
use App\Models\Category;
use App\Models\Tag;
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
        $post->featured = $request->has("featured")?1:0;
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
            return $post->load('category', 'tags')->setHidden(['created_at', 'updated_at']);
        return view("post.edit", compact('post'));
    }
    public function set_featured(Post $post) {
        $post->featured = !$post->featured;
        $post->save();
        return response('ok', 200);
    }
    public function update(Request $request, Post $post) {
        $request->validate([
            "title" => "required",
            "slug" => "required",
        ]);
        
        $post->title = $request->title;
        $post->slug = $request->slug;
        $post->excerpt = Str::words($request->content, 20, '(...)');
        $post->content = $request->content;
        $post->featured = $request->has("featured")?1:0;
        $post->save();
        //attach categories
        $post->category_id = $request->category_id;
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
        //associate tags
        $tagsId = [];
        foreach ($request->tags as $tag) {
            if(!array_key_exists('id', $tag)) {
                $new = Tag::create([
                    "name" => $tag['name'],
                    "slug" => \App\Helpers\Helper::make_slug($tag['name'])
                ]);
                $tagsId[] = $new->id;
            } else {
                $tagsId[] = $tag['id'];
            }
        }
        $post->tags()->attach($tagsId);
        //$post->tags()
        return response('ok', 200);
    }
    public function destroy (Post $post) 
    {
        // remove pic
        if(Storage::delete("public".$post->getRawOriginal('image'))){
            Storage::delete("public".preg_replace('/.webp/', '-small.webp',$post->getRawOriginal('image')));
            Storage::delete("public".preg_replace('/.webp/', '-medium.webp',$post->getRawOriginal('image')));
            if ($post->delete())
                return response('OK', 200);
        }
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
            "slug" => \App\Helpers\Helper::make_slug($request->name),
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
    public function tags(Request $request) {
        if ($request->ajax()) {
            return Tag::all();
        }
        return view("post.tags");
    }
    public function storeTag (Request $request) {
        $request->validate([
            "name" => "required|unique:tags|max:255",
        ]);
        Tag::create([
            "name" => $request->name,
            "slug" => \App\Helpers\Helper::make_slug($request->name)
        ]);
        return response("OK", 200);
    }
    public function updateTag (Tag $tag, Request $request) {
        $tag->name = $request->name;
        $tag->save();
        return response("OK", 200);
    }
    public function destroyTag (Tag $tag) {
        if ($tag->delete())
            return response("OK", 200);
        return response("Not ok", 500);
    }
    
    public function fetch(Request $request) {
        $query = Post::orderBy($request->sortBy, $request->sort);
        if($request->q)
            $query = $query->where("title", "like", "%$request->q%");
            
        return PostResource::collection($query->with('category')->paginate($request->perPage));
    }
}
