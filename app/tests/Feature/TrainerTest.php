<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Services\TrainerService;
use App\Models\Trainer;
use App\Models\Pokemon;

class TrainerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void 
    {
        parent::setup();
        $this->initDatabase();
    }

    public function tearDown(): void 
    {
        $this->resetDatabase();
        parent::tearDown();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_clean_pokemon()
    {
        $trainer = new Trainer();
        $trainer->name = 'test1';
        $trainer->washing_state = false;
        $trainer->save();
        $pokemon = new Pokemon();
        $pokemon->name = 'test';
        $pokemon->height = '10';
        $pokemon->is_cleaning =true;
        $pokemon->save();
        $trainer->pokemon()->attach($pokemon->id);

        TrainerService::cleanPokemon($trainer->id);
        $trainer = Trainer::find($trainer->id);
        $expected = '-1';

        $this->assertSame($expected, $trainer->pokemon()->first()->pivot->dirt);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_dirt_pokemon()
    {
        $trainer = new Trainer();
        $trainer->name = 'test1';
        $trainer->washing_state = false;
        $trainer->save();
        $pokemon = new Pokemon();
        $pokemon->name = 'test';
        $pokemon->height = '10';
        $pokemon->is_cleaning =true;
        $pokemon->save();
        $trainer->pokemon()->attach($pokemon->id);

        $test = TrainerService::dirtPokemon($trainer);
        $trainer = Trainer::find($trainer->id);
        $expected = '10';

        $this->assertGreaterThan($expected, $trainer->pokemon()->first()->pivot->dirt);
    }
}
