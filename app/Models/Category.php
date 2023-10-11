<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $fillable = ["name", "slug", "description", "parent_id"];

    public $timestamps = false;

    public function posts() 
    {
        return $this->hasMany(\App\Models\Post::class);
    }
    
    public function sources() 
    {
        return $this->hasMany(\App\Models\Source::class);
    }
    
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
    
    public function getAllPosts()
    {
        $descendantIds = $this->getDescendantIds($this->id);
        $categoryIds = array_merge([$this->id], $descendantIds);
        return Post::whereIn('category_id', $categoryIds);
    }

    protected function getDescendantIds($categoryId)
    {
        $descendantIds = [];
        $category = Category::find($categoryId);
        if ($category) {
            $children = $category->children;
            foreach ($children as $child) {
                $descendantIds[] = $child->id;
                if ($child->children->count() > 0) {
                    $descendantIds = array_merge($descendantIds, $this->getDescendantIds($child->id));
                }
            }
        }
        return $descendantIds;
    }
}
