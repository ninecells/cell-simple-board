<?php

namespace NineCells\SimpleBoard\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class SimpleBoardPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function sboardEdit($user, $item)
    {
        return $user->id === $item->writer_id;
    }
}
