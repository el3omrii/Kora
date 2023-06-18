<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Helper {

    public static function callApi($endpoint, $options=null) {
        return Http::withHeaders(["accept" => "application/json", "x-apisports-key" => env('SOCCER_TOKEN')])
        ->get(env('SOCCER_API'). $endpoint . $options);
    }
    public static function callTranslationApi($text) {
        return json_decode(Http::withHeaders([
            "accept" => "*/*",
            "x-api-key" => env('TRANSLATION_TOKEN'),
        ])->asForm()->post(env('TRANSLATION_API'), [
            "source_language" => "en",
            "translation_language" => "ar",
            "text" => $text
        ]));
    }    

    public static function createUploadFolder($post)
    {
        $year = $post->created_at->format('Y');
        $month = $post->created_at->format('m');

        $path = "/uploads/{$year}/{$month}";

        Storage::makeDirectory("public$path");
        return $path;
    }

    public static function createFolder($path)
    {
        $path = "/uploads/{$path}";

        Storage::makeDirectory("public$path");
        return $path;
    }

    public static function make_slug($string = null, $separator = "-") {
        if (is_null($string)) {
            return "";
        }
        $string = trim($string);
        $string = mb_strtolower($string, "UTF-8");
        // '/' and/or '\' if found and not remoeved it will change the get request route
        $string = str_replace('/', $separator, $string); 
        $string = str_replace('\\', $separator, $string);
        $string = preg_replace("/[^a-z0-9_\sءاأإآؤئبتثجحخدذرزسشصضطظعغفقكلمنهويةى]#u/", "", 
        $string);
        $string = preg_replace("/[\s-]+/", " ", $string);
        $string = preg_replace("/[\s_]/", $separator, $string);
        return $string;
    }

    public static function grab_image($url, $save_path) {
        $imageData = file_get_contents($url);
        $imageInfo = getimagesizefromstring($imageData);
        // Determine the file extension based on the MIME type
        $extension = image_type_to_extension($imageInfo[2]); // 2 represents the IMAGETYPE constant for the image type
        $image_path = "$save_path/" . Str::random(10) . $extension;
        Storage::put("public" . $image_path, $imageData);
        return $image_path;
    }
    public static function grab_logo($url, $save_path) {
        $imageName = basename($url);
        $image_path = "$save_path/$imageName";
        if (file_exists( public_path() . $image_path))
            return $image_path;
        $imageData = file_get_contents($url);
        Storage::put("public" . $image_path, $imageData);
        return $image_path;
    }
}