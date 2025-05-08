<?php

namespace App\Acme\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController
{
  #[Route('/acme/hello', name: 'acme_hello')]
  public function hello(): Response
  {
    return new Response('Hello from Acme!');
  }
}
