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

    /* For this to work, add these lines to usesFileParsers
    //quick fix
        $xmlString = str_replace("content:", "content_", $xmlString);
        $xmlString = str_replace("media:", "media_", $xmlString);
    */
    function entries(Source $source) {
        $items = cache()->remember("items" . $source->name, 3600, function () use ($source) {
		$web = new \Spekulatius\PHPScraper\PHPScraper;
		$web->setConfig([
  'agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51 Safari/537.36'
		]);
		//try {
			$rss = $web->rssRaw($source->feed_url); //\App\Models\Source::all()->where('name','Kooora')->first()->feed_url;
		/*} catch (\Exception $e) { 
            return response(null, 403)->json(['error' => 403]); 
        }*/
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

    function manual(Request $request) {
        $source = Source::findOrFail($request->source_id);
        $items = cache()->remember("items" . $source->name, 3600, function () use ($source, $request) {
            $web = new \Spekulatius\PHPScraper\PHPScraper;
            $rss = $web->parseXml($request->feed);
            
            $tree = (object)$rss['channel'];
            
            $items = [];
            foreach ($tree->item as $item) {

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
        return redirect()->route('source.scraper', ['source' => $request->source_id]);
    }

    function publish(Request $request) {
        $source = Source::find($request->source_id);
        $items = cache()->get('items' . $source->name);
        $record = $items[$request->index];
        if ($source->content_regex || $source->content_xpath) {
            // scrape for content
            $web = new \Spekulatius\PHPScraper\PHPScraper;
            if ($regex = $source->content_regex){
                $content = $web->go($record['link']);
                $script = $content->filter('//script[contains(text(),"article_content")]')->text();
                if (preg_match($regex, $script, $matches))
                    $content = $matches[1];
            }
            else {
                $content = $web->go($record['link'])->filter($source->content_xpath);
                $content = $content->text() ? $content->text() : $content->attr('content');
            //$content = $web->go($record['link'])->filter("//meta[@itemprop='articleBody']")->attr("content"); dd($content);//->text();
            }
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
        $post->image = \App\Helpers\Helper::grab_image($record['image'], $folder);
        //attach category
        $post->category_id = $source->category_id; 
        $post->save();
        
        return response('success', 204);
    }
}
