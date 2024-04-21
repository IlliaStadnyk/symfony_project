<?php

namespace App\Controller\Post;

use App\Controller\ApiController;
use App\Entity\Post;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PostCreateController extends ApiController
{
    public function __invoke(Request $request, EntityManagerInterface $entityManager)
    {
        $data = json_decode($request->getContent(), true);
        $user = $entityManager->getRepository(User::class)->findOneBy(['id' => $data['userId']]);
        $data['name'] = $user->getName();

        $post = new Post();
        $post->setName($user->getName());
        $post->setBody($data['body']);
        $post->setTitle($data['title']);
        $post->setUser($user);

        $entityManager->persist($post);
        $entityManager->flush();
        return $this->successResponse(["message" => "Success"], Response::HTTP_CREATED);
    }
}
