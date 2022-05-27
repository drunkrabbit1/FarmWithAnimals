<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property integer $id
 */
class Farm extends Model
{
    use HasFactory;

    public function animals(): BelongsToMany
    {
        return $this->belongsToMany(Animal::class, FarmAnimal::class);
    }

    public function pivotFarmAnimals(): HasMany
    {
        return $this->hasMany(FarmAnimal::class, 'farm_id', 'id');
    }
}
