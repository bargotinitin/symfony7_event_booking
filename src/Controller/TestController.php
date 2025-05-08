<?php

// src/Controller/TestController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use JohnSmith\MyCustomPackage\Service\MyService;

class TestController extends AbstractController
{
  #[Route('/test/recipe', name: 'test_recipe')]
  public function index(MyService $myService): Response
  {
    $result = $myService->someMethod(); // Calling the service method
    return new Response('Service result: ' . $result);
  }
}
