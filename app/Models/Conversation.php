<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    public $guarded = [];

    public function createdAt() : Attribute {
        return Attribute::make(
            get: fn($value) => Carbon::createFromTimestamp($value)->format('h:m')
        );
    }
}
