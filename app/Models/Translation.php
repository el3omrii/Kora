<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    protected $primaryKey = 'key';

    protected $fillable = ['key', 'original', 'value'];
}
