<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Services\CleaningCenterService;
use App\Models\Trainer;
use App\Models\Pokemon;
use App\Models\CleaningCenter;

class CleaningCenterTest extends TestCase
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
    public function test_generate_profits()
    {
        $cleaningCenter = CleaningCenter::first();
        $profits = $cleaningCenter->profits;
        $trainer = new Trainer();
        $trainer->name = 'trainer test';
        $trainer->washing_state = false;
        $trainer->cleaning_center_id = $cleaningCenter->id;
        $trainer->save();
        $pokemon = new Pokemon();
        $pokemon->name = 'pokemon test 1';
        $pokemon->height = '10';
        $pokemon->is_cleaning =true;
        $pokemon->save();
        $trainer->pokemon()->attach($pokemon->id);
        $pokemon = new Pokemon();
        $pokemon->name = 'pokemon test 2';
        $pokemon->height = '5';
        $pokemon->is_cleaning =true;
        $pokemon->save();
        $trainer->pokemon()->attach($pokemon->id);
        $expected = $profits + 30;
        CleaningCenterService::generateProfits($trainer);
        $cleaningCenter = CleaningCenter::first();
        $this->assertSame($expected, intval($cleaningCenter->profits));
    }
}
