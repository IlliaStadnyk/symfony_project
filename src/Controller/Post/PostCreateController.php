<?php

namespace App\Controller\Post;

use App\Controller\ApiController;
use App\Entity\AccessToken;
use App\Entity\Post;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface;

class PostCreateController extends ApiController
{
    public function __invoke( Request $request, EntityManagerInterface $entityManager)
    {
        $authorizationHeader = $request->headers->get('Authorization');
        if ($authorizationHeader && preg_match('/Bearer\s+(.+)/', $authorizationHeader, $matches)) {
            $token = $matches[1];
        }
        $userId= $entityManager->getRepository(AccessToken::class)->findOneBy(['token'=> $token]);
        $data = json_decode($request->getContent(), true);
        $user = $entityManager->getRepository(User::class)->findOneBy(['id' => $userId]);
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
