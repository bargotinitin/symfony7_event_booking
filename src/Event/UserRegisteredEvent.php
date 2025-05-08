<?php

// src/Event/UserRegisteredEvent.php

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

class UserRegisteredEvent extends Event
{
  public const NAME = 'user.registered';

  private $username;

  public function __construct(string $username)
  {
    $this->username = $username;
  }

  public function getUsername(): string
  {
    return $this->username;
  }
}
