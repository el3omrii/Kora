<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Route;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function with($request)
    {
        /*dd('right here');
        if (Route::currentRouteName() === "category_posts") {
            dd('right here');
            $category = \App\sModels\Category::first();//where('slug', $request->route('category'));
            return [
                'meta' => [
                    'category' => $category,
                ],
            ];
        }*/
    }
}
