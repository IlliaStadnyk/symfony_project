<?php

namespace App\Controller\User;

use App\Controller\ApiController;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserCreateController extends ApiController
{

    public function __invoke(Request $request, EntityManagerInterface $entityManager)
    {
        $userData = json_decode($request->getContent(), true);
//        $newUser = $userData->toArray();

        $user = new User();
        $user->setUsername($userData['username']);
        $user->setEmail($userData['email']);
        $user->setName($userData['name']);
        $user->setPassword(password_hash($userData['password'], PASSWORD_DEFAULT));
        $user->setRoles(['ROLE_USER']);
        $user->setPhone($userData['phone']);
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->successResponse([$user->jsonSerialize()]);
    }
}
