<?php

namespace App\Model;

use App\Entity\Users;

class UsersModel
{

    /**
     * Get data.
     */
    public static function getData($entityManager) {
      $users = $entityManager
        ->getRepository(Users::class)
        ->findAll();

      $data = [];
      foreach ($users as $user) {
        $data[] = [
          'id' => $user->getId(),
          'name' => $user->getUserName(),
          'email' => $user->getEmail(),
        ];
      }
      return $data;
    }

    /**
     * Save data.
     */
    public static function saveData($entityManager, $post_data)
    {
      $now = new \DateTime();
      $password = bin2hex(random_bytes(10)); // random string
      $hashed = hash('sha256', $password);

      $user = new Users();
      $user->setUserName($post_data['name']);
      $user->setPassword($hashed);
      $user->setEmail($post_data['email']);

      $user->setCreated($now);
      $user->setChanged($now);
      $user->setStatus(1);

      $entityManager->persist($user);
      $entityManager->flush();

      $data =  [
        'id' => $user->getId(),
        'username' => $user->getUserName(),
        'email' => $user->getEmail(),
      ];
      return $data;
    }
}
