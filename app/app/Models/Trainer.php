<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pokemon;

class Trainer extends Model
{
    use HasFactory;

    protected $table = "trainers";

    protected $fillable = ['name', 'washing_state'];

    public function pokemon()
    {
        return $this->belongsToMany(Pokemon::class)->withPivot('dirt');
    }
}
