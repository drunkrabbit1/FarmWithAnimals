<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id
 *
 * @property string $type
 * @property string $avatar
 *
 * @property int $max_size
 * @property int $min_size
 * @property int $max_age
 *
 * @property float $growth_rate
 */
class Animal extends Model
{
    use HasFactory;
}
