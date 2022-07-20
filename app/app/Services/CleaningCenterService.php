<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\CleaningCenter;
use Illuminate\Support\Facades\DB;
use App\Models\Trainer;

class CleaningCenterService {

    /**
     * Show the complete list of cleaning centers and trainers
     * @return [stdClass] list of cleaning centers and trainers
     */
    public static function index () {
        $query = DB::table('trainers')
            ->join('pokemon_trainer', 'pokemon_trainer.trainer_id', '=', 'trainers.id')
            ->join('pokemon', 'pokemon.id', '=', 'pokemon_trainer.pokemon_id')
            ->select('trainers.id','trainers.name as trainer_name', 'trainers.cleaning_center_id', 'pokemon.name as pokemon_name', 'trainers.washing_state', 'pokemon_trainer.dirt')
            ->get();
        $trainers = [];
        $lastId = 0;
        $tempTrainer = null;
        $tempPokemon = null;
        foreach ($query as $trainer) {
            if ($lastId != $trainer->id) {
                if ($lastId != 0) {
                    array_push($trainers, $tempTrainer);
                }
                $lastId = $trainer->id;
                $tempTrainer = new \stdClass;
                $tempTrainer->id = $trainer->id;
                $tempTrainer->name = $trainer->trainer_name;
                $tempTrainer->cleaning_center_id = $trainer->cleaning_center_id;
                $tempTrainer->washing_state = $trainer->washing_state;
                $tempTrainer->pokemon = [];
            }
            $tempPokemon = new \stdClass;
            $tempPokemon->name = $trainer->pokemon_name;
            $tempPokemon->dirt = $trainer->dirt;
            array_push($tempTrainer->pokemon, $tempPokemon);
        }
        if (count($query) > 0) {
            array_push($trainers, $tempTrainer);
        }
        $response = new \stdClass;
        $response->cleaning_centers = CleaningCenter::all();
        $response->trainers = $trainers;
        return $response;
    }

    /**
     * Generate the profits based in the height's pokemon team of a trainer
     * @param [Trainer] $trainer trainer to calculate
     */
    public static function generateProfits (Trainer $trainer) {
        $profits = 0;
        foreach ($trainer->pokemon as $pokemon) {
            if ($pokemon->is_cleaning) {
                $profits += $pokemon->height * 2;
            }
        }
        $cleaningCenter = CleaningCenter::find($trainer->cleaning_center_id);
        $cleaningCenter->profits += $profits;
        $cleaningCenter->save();
    }
}