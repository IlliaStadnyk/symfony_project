<?php

namespace App\Controller\Post;

use App\Controller\ApiController;
use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class PostCollectionController extends ApiController
{
    public function __invoke(EntityManagerInterface $entityManager): Response
    {
        $response = $entityManager->getRepository(Post::class)->findAll();
        $serializedPosts = array_map(function ($post){
            return $post->jsonSerialize();
        }, $response);

        return $this->successResponse($serializedPosts);
    }
}
