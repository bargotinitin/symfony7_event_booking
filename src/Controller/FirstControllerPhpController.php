<?php

namespace App\Controller;

use App\Dto\SuccessDto;
use App\Entity\Users;
use App\Form\SecondFormType;
use App\Model\UsersModel;
use App\Service\MessageGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class FirstControllerPhpController extends AbstractController
{
    #[Route('/', name: 'app_first_controller_php')]
    public function index(): Response
    {
        return $this->render('first_controller_php/index.html.twig', [
            'controller_name' => 'FirstControllerPhpController',
        ]);
    }

    #[Route('/user/create', name: 'user_create')]
    public function userCreate(Request $request, EntityManagerInterface $em): Response
    {
        $users = new Users();
        $form = $this->createForm(SecondFormType::class, $users);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $user = $form->getData();


            $now = new \DateTime();
            $password = bin2hex(random_bytes(10)); // random string
            $hashed = hash('sha256', $password);

            $user->setUserName($form->get('username')->getData());
            $user->setPassword($hashed);
            $user->setEmail($form->get('email')->getData());

            $user->setCreated($now);
            $user->setChanged($now);
            $user->setStatus(1);

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('app_first_controller_php');

        }

        return $this->render(
            'form/usercreate.html.twig',
            [
                'form' => $form->createView()
            ]
            );
    }

    #[Route('/users', name: 'users_list')]
    public function list(EntityManagerInterface $entityManager): JsonResponse
    {
        $data = UsersModel::getData($entityManager);
        return $this->json(new SuccessDto($data));
    }


    #[Route('/notify', name: 'app_notify')]
    public function notify(MessageGenerator $msgSender): Response
    {
        $msgSender->send('user@example.com', 'Hello from Symfony 7!');

        return new Response('Notification sent!');
    }


}
