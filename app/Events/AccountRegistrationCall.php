<?php

namespace App\Events;

// use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class AccountRegistrationCall {
    use Dispatchable;//SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */

    public $user;

    public function __construct($user){
        $this->user = $user;
    }
}