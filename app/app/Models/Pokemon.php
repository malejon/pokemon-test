<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Trainer;

class Pokemon extends Model
{
    use HasFactory;

    protected $table = "pokemon";

    protected $fillable = ['id', 'name', 'height', 'is_cleaning'];

    public function trainers()
    {
        return $this->belongsToMany(Trainer::class);
    }
}
