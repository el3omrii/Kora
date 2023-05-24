<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MatchController extends Controller
{
    public function index() {
        return view("match.index");
    }
    public function scheduled() {
        return view("match.scheduled");
    }
    
}
