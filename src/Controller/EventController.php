<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Event;
use App\Entity\Users;
use App\Model\EventModel;
use App\Utils\ArrayHelper;
use App\Validations\Validate;

#[Route('/api', name: 'api_')]
class EventController extends AbstractController
{
    #[Route('/event', name: 'event_index', methods:['get'] )]
    public function index(EntityManagerInterface $entityManager): JsonResponse
    {
        $data = EventModel::getAllData($entityManager);
        return $this->json($data);
    }


    #[Route('/event', name: 'event_create', methods:['post'] )]
    public function create(EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $post_data = json_decode($request->getContent(), true);
        $validate = Validate::validateEvent($entityManager, $post_data);
        if ($validate) {
            return $this->json($validate, 404);
        }
        $data = EventModel::saveData($entityManager, $post_data);
        return $this->json($data);
    }


    #[Route('/event/{id}', name: 'event_show', methods:['get'] )]
    public function show(EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $data = EventModel::getData($entityManager, $id);
        if (!is_array($data)) {
            return $this->json($data, 404);
        }
        return $this->json($data);
    }

    #[Route('/event/{id}', name: 'event_update', methods:['put', 'patch'] )]
    public function update(EntityManagerInterface $entityManager, Request $request, int $id): JsonResponse
    {
        $post_data = json_decode($request->getContent(), true);
        $validate = Validate::validateUpdateEvent($entityManager, $post_data, $id);
        if (!empty($validate)) {
            return $this->json($validate, 404);
        }
        $data = EventModel::updateData($entityManager, $post_data, $id);
        return $this->json($data);
    }

    #[Route('/event/{id}', name: 'event_delete', methods:['delete'] )]
    public function delete(EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $data = EventModel::deleteData($entityManager, $id);
        if (!is_array($data)) {
            return $this->json($data, 404);
        }
        return $this->json($data['message']);
    }
}
