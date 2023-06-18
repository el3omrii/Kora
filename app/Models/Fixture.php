<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fixture extends Model
{


    protected $guarded = [];

    protected $casts = [
        'fixture_data' => 'array'
    ];

    protected function getLeagueLogoAttribute($value) {
        $settings = \App\Models\Settings::first();
        if ($settings->cdn) {
            return $settings->cdn_url . $value;
        }
        return $value;
    }
    protected function getHomeLogoAttribute($value) {
        $settings = \App\Models\Settings::first();
        if ($settings->cdn) {
            return $settings->cdn_url . $value;
        }
        return $value;
    }
    protected function getAwayLogoAttribute($value) {
        $settings = \App\Models\Settings::first();
        if ($settings->cdn) {
            return $settings->cdn_url . $value;
        }
        return $value;
    }

}
