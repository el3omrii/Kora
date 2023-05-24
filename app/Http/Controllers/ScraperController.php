<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Source;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class ScraperController extends Controller
{
    function scrape(Source $source)
    {
        return view("scraper", compact("source"));
    }

    function entries(Source $source) {
        $items = cache()->remember("items" . $source->name, 3600, function () use ($source) {
            $web = new \Spekulatius\PHPScraper\PHPScraper;
            $rss = $web->rssRaw($source->feed_url); //\App\Models\Source::all()->where('name','Kooora')->first()->feed_url;
            $tree = (object)$rss[0];
            $items = [];
            foreach ($tree->channel["item"] as $item) {

                $record = [
                    'title' => $item['title'],
                    'description' => $item['description'],
                    'image' => $item[$source->image_type]["@attributes"]["url"],
                    'link' => $item['link'],
                    'content' => key_exists('content_encoded', $item) ? $item['content_encoded'] : '' ,
                    'pubDate' => $item['pubDate'],
                    'checked' => false
                ];
                $items[] = $record;
            }
            return $items;
        });
        return response()->json($items);
    }

    function publish(Request $request) {
        $source = Source::find($request->source_id);
        $items = cache()->get('items' . $source->name);
        $record = $items[$request->index];
        if ($source->content_regex) {
            // scrape for content
            $web = new \Spekulatius\PHPScraper\PHPScraper;
            $content = $web->go($record['link'])->filter($source->content_regex);
            $content = $content->text() ? $content->text() : $content->attr('content');
            //$content = $web->go($record['link'])->filter("//meta[@itemprop='articleBody']")->attr("content"); dd($content);//->text();
        } else {
            $content = strip_tags($record['content']);
        }
        // create article
        $post = new Post([
            'title' => $record['title'],
            'slug' => \App\Helpers\Helper::make_slug($record['title']),
            'source_link' => $record['link'],
            'excerpt' => Str::words($record['description'], 20, '(...)'),
            'content' => $content,
            //'image' => $record['image']
        ]);
        // save post 
        $source->posts()->save(($post));
        //upload pic
        $folder = \App\Helpers\Helper::createUploadFolder($post);
        $image = file_get_contents($record['image']);
        $name = substr($record['image'], strrpos($record['image'], '/') + 1);
        $image_path = $folder .'/'. $name;
        Storage::put("public/$image_path", $image);
        $post->image = $image_path;
        $post->save();
        // publish post in the same category as the source
        $post->categories()->attach($source->category_id);
        return response('success', 204);
    }
}
