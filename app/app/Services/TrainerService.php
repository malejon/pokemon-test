<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Trainer;
use App\Models\Pokemon;
use Illuminate\Support\Facades\DB;

class TrainerService {

    /**
     * Create a trainer and ramdomly team of pokemon
     *
     * @return [Trainer] trainer created
     */
    public static function create (String $name) {
        $trainer = new Trainer();
        $trainer->name = $name;
        $trainer->washing_state = false;
        $trainer->save();
        $numPokemon = rand(1,6);
        for ($i=0; $i < $numPokemon; $i++) { 
            $randomId = rand(1,150);
            $pokemon = Pokemon::find($randomId);
            if (is_null($pokemon)) {
                $response = Http::get('https://pokeapi.co/api/v2/pokemon/'.$randomId);
                $pokemon = new Pokemon();
                $pokemon->id = $randomId;
                $pokemon->name = $response['name'];
                $pokemon->height = $response['height'];
                $pokemon->is_cleaning = (rand(1,6) < 5 ? true : false);
                $pokemon->save();
            }
            $trainer->pokemon()->attach($randomId);
        }
        return $trainer;
    }

    /**
     * Modify the state of trainer
     * @param [bool] $state state of trainer
     * @param [int] $cleaning_center_id id of cleaning center
     * @param [int] $id id of trainer
     * @return [Trainer] trainer created
     */
    public static function edit (bool $state, int $cleaning_center_id, int $id) {
        $trainer = Trainer::find($id);
        $trainer->washing_state = $state;
        if ($cleaning_center_id == 0) {
            $trainer->cleaning_center_id = null;
        } else {
            $trainer->cleaning_center_id = $cleaning_center_id;
        }
        $trainer->save();
        return $trainer;
    }

    /**
     * Dirt the team pokemon of a trainer
     * @param [Trainer] $trainer trainer to dirt his pokemon
     */
    public static function dirtPokemon (Trainer $trainer) {
        foreach ($trainer->pokemon as $pokemon) {
            if ($pokemon->pivot->dirt < 100) {
                if ($pokemon->pivot->dirt == -1) {
                    $pokemon->pivot->dirt = 0;
                } else {
                    $pokemon->pivot->dirt = $pokemon->pivot->dirt += rand(1,10);
                }
                $pokemon->pivot->save();
            }
        }
    }

    /**
     * Clean the pokemon team of a trainer
     * @param [int] $id id of trainer to clean pokemon team
     */
    public static function cleanPokemon (int $id) {
        DB::table('pokemon_trainer')
            ->join('pokemon', 'pokemon_trainer.pokemon_id', '=', 'pokemon.id')
            ->where('pokemon_trainer.trainer_id', $id)
            ->where('pokemon.is_cleaning', 1)
            ->update(['pokemon_trainer.dirt' => -1]);
    }


}