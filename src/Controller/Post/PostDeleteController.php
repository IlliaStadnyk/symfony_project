<?php

namespace App\Controller\Post;

use App\Controller\ApiController;
use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;

class PostDeleteController extends ApiController
{
    public function __invoke(EntityManagerInterface $entityManager,Security $security, Post $post)
    {
        $authUser = $security->getUser();
        $postUser = $post->getUser();
        if($authUser !== $postUser){
            return $this->errorResponse(["message"=>"Failed to delete post. You dont own that post"]);
        }
        $entityManager->remove($post);
        $entityManager->flush();
        return $this->successResponse(["message" => "Succeed deleted"], Response::HTTP_OK);
    }
}
