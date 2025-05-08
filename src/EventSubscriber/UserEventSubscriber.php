<?php

// src/EventSubscriber/UserEventSubscriber.php

namespace App\EventSubscriber;

use App\Event\UserRegisteredEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserEventSubscriber implements EventSubscriberInterface
{
  public static function getSubscribedEvents(): array
  {
    return [
      UserRegisteredEvent::NAME => 'onUserRegistered',
    ];
  }

  public function onUserRegistered(UserRegisteredEvent $event)
  {
    $username = $event->getUsername();
    echo '<b>Event Subscriber:</b> User registered in subscriber: ' . $username . "<br/>";
  }
}
