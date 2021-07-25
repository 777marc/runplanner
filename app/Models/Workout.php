<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function WorkoutType()
    {
        return $this->hasOne(WorkoutType::class, 'id', 'workout_type_id');
    }
}
