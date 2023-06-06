<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Source;
use Illuminate\Http\RedirectResponse;

class SourceController extends Controller
{
    public function index (Request $request) {
        $editedsource = null;
        if($id = $request->input('edit')){
            $editedsource = Source::findOrFail($id);
        }
        $categories = Category::all();
        $sources = Source::all();
        return view("source.index", compact(["sources", "editedsource", "categories"]));
    }

    public function store(Request $request) : RedirectResponse {
        $validated = $request->validate([
            "name" => "required|unique:sources|max:255",
            "feed_url" => "required",
            "category" => "required"
        ]);
        $upload = '';
        if ($file = $request->file("source_image")) {
            $upload = $file->storeAs("/uploads", preg_replace('/\s+/','',$request->name).'.'.$file->extension(), 'public');
        }
        if ($request->content_type == "regex")
        Source::create([
            "name" => $request->name,
            "feed_url" => $request->feed_url,
            "description" => $request->description,
            "logo" => $upload,
            "content_regex" => $request->content_type == "regex" ? $request->content_regex : null,
            "content_xpath" => $request->content_type == "xpath" ? $request->content_regex : null,
            "image_type" => $request->image_type,
            "category_id" => $request->category
        ]);
        return redirect('/sources')->with("message", (object)["type"=>"success" , "content" => "source was created"]);
    }
    public function update(Source $source, Request $request) {
        $validated = $request->validate([
           // "name" => "required|unique:sources,$source->id|max:255",
            "feed_url" => "required",
            "category" => "required"
        ]);
        if ($file = $request->file("source_image")) {
            //remove old pic
            unlink(public_path($source->logo));
            //store new one
            $upload = $file->storeAs("/uploads", preg_replace('/\s+/','',$request->name).'.'.$file->extension(), 'public');
            $source->logo = $upload;
        }
        $source->name = $request->name;
        $source->feed_url = $request->feed_url;
        $source->description = $request->description;
        $source->category_id = $request->category;
        $source->content_regex = $request->content_regex;
        $source->image_type = $request->image_type;
        if ($source->save())
            return redirect('/sources')->with("message", (object)["type"=>"success" , "content" => "source was updated"]);
        return redirect('/sources')->with("message", (object)["type" => "danger" , "content" => "something wrong happened"]);    
    }
    public function destroy(Source $source) {
        if (file_exists(public_path($source->logo))) {
            if(unlink(public_path($source->logo)))
                if($source->delete()) {
                    session()->flash("message", (object)["type"=>"success" , "content" => "source was deleted"]);
                    return response('success', 204);
                }
        } else { 
            if($source->delete()) {
                session()->flash("message", (object)["type"=>"success" , "content" => "source was deleted"]);
                return response('success', 204);
            }
        }
        session()->flash("message", (object)["type"=>"danger" , "content" => "something went wrong"]);
        return response('error', 400);
    }
}
