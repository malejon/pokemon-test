<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CleaningCenterService;
use App\Services\TrainerService;
use App\Jobs\CleanPokemon;
use Carbon\Carbon;

class CleaningCenterController extends Controller
{
    public function index () {
        return view('main.main', ["response"=>CleaningCenterService::index()]);
    }

    public function startCleaning (Request $request) {
        $trainer = TrainerService::edit(true, intval($request['cleaning_center_id']), intval($request['id']));
        $job = (new CleanPokemon($trainer))->delay(Carbon::now()->addSeconds(60));
        $this->dispatch($job);
        return redirect()->route("main");
    }
}
