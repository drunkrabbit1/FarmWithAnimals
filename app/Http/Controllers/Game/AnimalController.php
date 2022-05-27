<?php

namespace App\Http\Controllers\Game;

use App\Http\Controllers\Controller;
use App\Http\Requests\AnimalCreateRequest;
use App\Jobs\AnimalLifeCycleJob;
use App\Models\Animal;
use App\Models\Farm;

class AnimalController extends Controller
{
    public function create(AnimalCreateRequest $request)
    {
        $user = $request->user();
        /** @var Farm $farm */
        $farm = $request->user()->farm()->first();
        $animal = Animal::query()->find($request->id, ['id', 'min_size']);

        if ($farm->animals()->where('animals.id', $animal->id)->doesntExist()) {
            $farm->animals()->attach($animal->id, ['size' => $animal->min_size]);

            AnimalLifeCycleJob::dispatch($farm, $animal, $user)->delay(10 * $animal->growth_rate ?: 1);
        }

        return redirect()->back();
    }
}
