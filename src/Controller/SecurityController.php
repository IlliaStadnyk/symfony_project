<?php

namespace App\Controller;

use App\Entity\AccessToken;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class SecurityController extends ApiController
{

    #[Route('/api/login', name: 'app_login', methods: ['POST'])]
    public function login( EntityManagerInterface $entityManager, #[CurrentUser]User $user = null): Response
    {

        if($user){
            $token = new AccessToken();
            $token->setUserId($user->getId());
            $token->setUser($user);

            $entityManager->persist($token);
            $entityManager->flush();
        }


        return $this->successResponse([
            'user' => $user->getName(),
            'token' => $token->getToken(),
        ]);


    }
    #[Route('/api/logout', name: 'app_logout', methods: ['POST'])]
    public function logout(Security $security, EntityManagerInterface $entityManager): Response
    {
        $user = $security->getUser();
        if(!$user){
            return $this->errorResponse(['message'=> 'not logged in']);
        }
        $tokensToDelete = $entityManager->getRepository(AccessToken::class)->findBy(['userId'=>$user->getId()]);
        foreach ($tokensToDelete as $token) {
            $entityManager->remove($token);
        }

        $entityManager->flush();
        return $this->successResponse(['message' => 'Logged out']);
    }
}
