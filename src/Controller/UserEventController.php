<?php

// src/Controller/UserController.php

namespace App\Controller;

use App\Event\UserRegisteredEvent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserEventController extends AbstractController
{

  #[Route('/register', name: 'register')]
  public function register(Request $request, EventDispatcherInterface $eventDispatcher): Response
  {
    $username = 'john_doe'; // Just a string for the username

    // Dispatch the event with the username
    $eventDispatcher->dispatch(new UserRegisteredEvent($username), UserRegisteredEvent::NAME);

    $request->getSession()->getFlashBag()->add('success', 'Your data was saved successfully!');
    return new Response('---- User registered and event dispatched -----');
  }
}
