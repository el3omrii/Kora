<?php

namespace App\Http\Controllers;

use App\Models\Fixture;
use App\Http\Resources\FixtureResource;
use App\Models\Translation;
use App\Http\Resources\TranslationResource;
use Illuminate\Http\Request;
use App\Helpers\Helper;

class ApiController extends Controller
{
    public function fixtures() {
        $data = cache()->remember("fixtures4", 3600, function() {
            return json_decode(Helper::callApi("fixtures", "?date=" . today()->format("Y-m-d") . "&season=2022"));
        });
        // filter based on leagues
        $leagues = json_decode(env("LEAGUES_ID"));
        $data->response = array_values(array_filter($data->response, function($item) use ($leagues){
            return in_array($item->league->id, $leagues);
        }));
        return response()->json($data);
    }
    public function publish (Request $request) {
        $fixture = new Fixture([
            'fixture_id' => $request->input('fixture_id'),
            'date'      => $request->input('fixture_data')['fixture']['date'],
            'fixture_data' => $request->input('fixture_data')
        ]);
        //check for translations
        $home = [
            'id' => $request->fixture_data["teams"]["home"]["id"],
            'name' => $request->fixture_data["teams"]["home"]["name"],
        ];
        $away = [
            'id' => $request->fixture_data["teams"]["away"]["id"],
            'name' => $request->fixture_data["teams"]["away"]["name"],
        ];
        $league = [
            'id' => $request->fixture_data["league"]["id"],
            'name' => $request->fixture_data["league"]["name"],
        ];
        if ($trans = Translation::find($home['id']))
            $fixture->home = $trans->value;
        else {
            $trans = Helper::callTranslationApi($home['name'])->translation;
            Translation::create([
                "key" => $home['id'],
                "original" => $home['name'],
                "value" => $trans
            ]);
            $fixture->home = $trans;
        }
        if ($trans = Translation::find($away['id']))
            $fixture->away = $trans->value;
        else {
            $trans = Helper::callTranslationApi($away['name'])->translation;
            Translation::create([
                "key" => $away['id'],
                "original" => $away['name'],
                "value" => $trans
            ]);
            $fixture->away = $trans;
        }
        if ($trans = Translation::find($league['id']))
            $fixture->league = $trans->value;
        else {
            $trans = Helper::callTranslationApi($league['name'])->translation;
            Translation::create([
                "key" => $league['id'],
                "original" => $league['name'],
                "value" => $trans
            ]);
            $fixture->league = $trans;
        }
        $fixture->save();
        return $fixture;
    }
    public function scheduled  (Request $request) {
        return FixtureResource::collection(Fixture::paginate($request->perPage));
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
}
