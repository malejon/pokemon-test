<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CleaningCenter extends Model
{
    use HasFactory;

    protected $table = "cleaning_centers";

    protected $fillable = ['id', 'spots', 'profits'];

}
