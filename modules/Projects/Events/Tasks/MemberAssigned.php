<?php

namespace Modules\Projects\Events\Tasks;

use App\Abstracts\Event;
use App\Models\Auth\User;
use Modules\Projects\Models\Task;

class MemberAssigned extends Event
{
    public $task;

    public $user;

    public $notification;

    /**
     * Create a new event instance.
     *
     * @param Task $task
     * @param User $user
     * @param string $notification
     */
    public function __construct(Task $task, User $user, string $notification)
    {
        $this->task = $task;
        $this->user = $user;
        $this->notification = $notification;
    }
}
