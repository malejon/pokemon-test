<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\TrainerService;
use App\Services\CleaningCenterService;
use App\Models\Trainer;

class CleanPokemon implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $trainer;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Trainer $trainer)
    {
        $this->trainer = $trainer;
    }

    /**
     * Execute the job of a clean pokemon team of a trainer
     *
     * @return void
     */
    public function handle()
    {
        TrainerService::cleanPokemon($this->trainer->id);
        CleaningCenterService::generateProfits($this->trainer);
        TrainerService::edit(false, 0, $this->trainer->id);
    }
}
