<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AnimalRemoveEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private User $user;
    private int $animalId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(int $animalId, User $user)
    {
        $this->animalId = $animalId;
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
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->animalId
        ];
    }
}
