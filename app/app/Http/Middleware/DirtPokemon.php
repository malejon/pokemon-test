<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Trainer;
use App\Services\TrainerService;

class DirtPokemon
{
    /**
     * Handle an incoming request.
     * Add more dirt to pokemon dont were in a cleaning center
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $trainers = Trainer::where('cleaning_center_id', null)->get();
        foreach ($trainers as $trainer) {
            TrainerService::dirtPokemon($trainer);
        }
        return $next($request);
    }
}
