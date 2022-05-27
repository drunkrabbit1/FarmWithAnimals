<?php

namespace App\Jobs;

use App\Events\AnimalDevEvent;
use App\Events\AnimalRemoveEvent;
use App\Models\Animal;
use App\Models\Farm;
use App\Models\FarmAnimal;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AnimalLifeCycleJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Animal $animal;
    public Farm $farm;
    public User $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Farm|int $farm, Animal|int $animal, User|int $user)
    {
        $this->farm = $farm instanceof Farm ? $farm : Farm::query()->find($farm);
        $this->animal = $animal instanceof Animal ? $animal : Animal::query()->find($animal);
        $this->user = $user instanceof User ? $user : User::query()->find($user);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        /** @var FarmAnimal $farmAnimal */
        $farmAnimal = $this->farm
            ->pivotFarmAnimals()
            ->where('farm_animal.animal_id', $this->animal->id)
//            ->select('farm_animal.id', 'farm_animal.size', 'farm_animal.age')
            ->first();

        $isLive = $farmAnimal->age < $this->animal->max_age;
        if ($isLive) {
            $this->nextLvl($farmAnimal);
        } else {
            $this->die($farmAnimal);
        }
    }

    private function nextLvl(FarmAnimal $farmAnimal)
    {
        $size = $farmAnimal->size;
        $farmAnimal->update([
            'size' => min($size + $this->animal->growth_rate, $this->animal->max_size),
            'farm_animal.age' => $farmAnimal->age++,
        ]);

        AnimalDevEvent::broadcast($this->farm, $this->user);

        self::dispatch($this->farm, $this->animal, $this->user)
            ->delay(15);
    }

    private function die(FarmAnimal $farmAnimal)
    {
        AnimalRemoveEvent::broadcast($farmAnimal->id, $this->user);
        $farmAnimal->delete();
    }
}
