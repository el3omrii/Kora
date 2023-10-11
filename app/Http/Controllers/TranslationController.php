<?php

namespace App\Http\Controllers;

use App\Models\Translation;
use App\Http\Resources\TranslationResource;
use Illuminate\Http\Request;
use App\Helpers\Helper;

class TranslationController extends Controller
{
    public function index () {
        return view("translation.index");
    }
    public function translations (Request $request) {
        $query = Translation::orderBy($request->sortBy, $request->sort);
        if($request->q)
            $query = $query->where("original", "like", "%$request->q%");
        return TranslationResource::collection($query->paginate($request->perPage));
    }
    public function saveTranslation (Translation $translation, Request $request) {
        $translation->value = $request->value;
        $translation->save();
        return response('ok', 200);
    }
    public function destroy (Translation $translation) {
        if ($translation->delete())
            return response('ok', 200);
        return response('error', 502);
    }
}
