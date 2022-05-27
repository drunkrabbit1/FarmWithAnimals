<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property integer $id
 *
 * @property integer $size
 * @property integer $age
 *
 * @property integer $farm_id
 * @property integer $animal_id
 */
class FarmAnimal extends Pivot
{
    protected $fillable = ['id', 'size', 'age'];
}
