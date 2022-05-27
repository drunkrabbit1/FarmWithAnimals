<?php

namespace App\Events;

use App\Models\Farm;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AnimalDevEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Farm $farm;
    private User $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Farm $farm, User $user)
    {
        $this->farm = $farm;
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel("{$this->user->email}{$this->user->id}");
        return new PrivateChannel("{$this->user->email}[{$this->user->id}]");
    }

    public function broadcastWith()
    {
        return $this->farm
            ->pivotFarmAnimals()
            ->select('id', 'size')
            ->get()
            ->all();
    }
}
