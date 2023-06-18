<?php

namespace App\Http\Controllers;

use App\Models\Fixture;
use App\Http\Resources\FixtureResource;
use Illuminate\Http\Request;
use App\Models\Translation;
use App\Helpers\Helper;
use Carbon\Carbon;
class MatchController extends Controller
{
    public function index() {
        return view("match.index");
    }
    public function scheduled() {
        return view("match.scheduled");
    }
    
    public function fixtures() {
        $data = cache()->remember("fixtures", 3600, function() {
            return json_decode(Helper::callApi("fixtures", "?date=". today()->format("Y-m-d") . "&season=2022"));
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
        $venue = [
            'id' => $fixture->fixture_data["fixture"]["venue"]["id"],
            'name' => $fixture->fixture_data["fixture"]["venue"]["name"] . ', ' . $fixture->fixture_data["fixture"]["venue"]["city"],
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
        if ($trans = Translation::find($venue['id']))
            $fixture->venue = $trans->value;
        else {
            $trans = Helper::callTranslationApi($league['name'])->translation;
            Translation::create([
                "key" => $venue['id'],
                "original" => $venue['name'],
                "value" => $trans
            ]);
            $fixture->venue = $trans;
        }
        // check for logos
        $home_logo = $request->fixture_data["teams"]["home"]["logo"];
        $away_logo = $request->fixture_data["teams"]["away"]["logo"];
        $league_logo = $request->fixture_data["league"]["logo"];
        //upload logos
        $folder = Helper::createFolder("teams");
        $fixture->home_logo = Helper::grab_logo($home_logo, $folder);
        $fixture->away_logo = Helper::grab_logo($away_logo, $folder);
        $folder = Helper::createFolder("leagues");
        $fixture->league_logo = Helper::grab_logo($league_logo, $folder);
        
        $fixture->save();
        return $fixture;
    }
    public function update (Fixture $fixture) {
        //check for translations
        $home = [
            'id' => $fixture->fixture_data["teams"]["home"]["id"],
            'name' => $fixture->fixture_data["teams"]["home"]["name"],
        ];
        $away = [
            'id' => $fixture->fixture_data["teams"]["away"]["id"],
            'name' => $fixture->fixture_data["teams"]["away"]["name"],
        ];
        $league = [
            'id' => $fixture->fixture_data["league"]["id"],
            'name' => $fixture->fixture_data["league"]["name"],
        ];
        $venue = [
            'id' => $fixture->fixture_data["fixture"]["venue"]["id"],
            'name' => $fixture->fixture_data["fixture"]["venue"]["name"] . ', ' . $fixture->fixture_data["fixture"]["venue"]["city"],
        ];
        if ($trans = Translation::find($home['id']))
            $fixture->home = $trans->value;
        if ($trans = Translation::find($away['id']))
            $fixture->away = $trans->value;
        if ($trans = Translation::find($league['id']))
            $fixture->league = $trans->value;
        if ($trans = Translation::find($venue['id']))
            $fixture->venue = $trans->value;
        
        $fixture->save();
        return $fixture;
    }
    public function destroy(Fixture $fixture) {
        if ($fixture->delete())
        return response('OK', 200);
    }
    public function load_scheduled (Request $request) {
        return FixtureResource::collection(Fixture::paginate($request->perPage));
    }
}
