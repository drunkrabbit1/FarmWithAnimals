<?php

namespace App\Http\Controllers\Game;

use App\Jobs\AnimalLifeCycleJob;
use App\Models\Animal;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class MainController extends Controller
{
    public function __invoke(Request $request): \Inertia\Response
    {
        $user = $request->user();
        $this->updateFarm($user);

        /** @var Collection $animalFarmList */
        $animalFarmList = $user->farm
            ->animals()
            ->withPivot('size as size', 'id')
            ->get();
        $animalList = Animal::query()
            ->select('id', 'avatar')
            ->get()
            ->map(function (Animal $animal) use($animalFarmList) {
                    $farmAnimal = $animalFarmList->where('id', $animal->id);
                if ($farmAnimal->isNotEmpty()) {
                    $animal->setAttribute('selected', true);
                    $animal->setAttribute('size', $farmAnimal->get('size', 1));
                } else {
                    $animal->setAttribute('selected', false);
                }

                return $animal;
            });

        return Inertia::render('Game/Main', [
            'animals' => $animalList,
            'farm.animals' => $animalFarmList
        ]);
    }

    private function updateFarm(User $user)
    {
        if (is_null($user->getAttribute('farm_id'))) {
            $user->update([
                'farm_id' => $user->farm()->create()->id
            ]);
        }
    }
}
