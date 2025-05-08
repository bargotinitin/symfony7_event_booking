<?php

// src/EventListener/UserRegisteredListener.php

namespace App\EventListener;

use App\Event\UserRegisteredEvent;

class UserRegisteredListener
{
  public function onUserRegistered(UserRegisteredEvent $event)
  {
    // Accessing the username passed with the event
    $username = $event->getUsername();

    // For example, log the registration
    echo '<b>In Listerner:</b> User registered: ' . $username . "<br/>";
  }
}
