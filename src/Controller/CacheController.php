<?php

// src/Controller/CacheController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CacheController extends AbstractController
{

  #[Route('/cache/check', name: 'cache_check')]
  public function index(): Response
  {
    // Create a cache pool
    $cache = new FilesystemAdapter();

    // Manually create a cache item and set its value
    $cacheItem = $cache->getItem('expensive_data');

    // Check if the cache item already exists and if not, set a value
    if (!$cacheItem->isHit()) {
      // Set the value in the cache
      $cacheItem->set('This is the result of the expensive operation');

      // Save the cache item (store it in the cache)
      $cache->save($cacheItem);
    }

    // Retrieve the cached value
    $cachedValue = $cacheItem->get();

    return new Response('Cached Value: ' . $cachedValue);
  }

  #[Route('/cache/check2', name: 'cache_check2')]
  public function index2(): Response
  {
    $cache = new FilesystemAdapter();

    // Create a cache item with a tag
    $cacheItem = $cache->getItem('user_profile_123');
    if (!$cacheItem->isHit()) {
      $cacheItem->set('User Profile Data for User 123');
      $cacheItem->tag(['user_profiles']);
      $cache->save($cacheItem);
    }

    // Get the cached value
    return new Response('Cached Value: ' . $cacheItem->get());
  }

  public function invalidateCache(): Response
  {
    $cache = new FilesystemAdapter();
    // Invalidate all cache items with the 'user_profiles' tag
    $cache->invalidateTags(['user_profiles']);

    return new Response('Cache invalidated for user profiles.');
  }


}
