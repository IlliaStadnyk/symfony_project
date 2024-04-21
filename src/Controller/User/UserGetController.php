<?php

namespace App\Controller\User;

use App\Controller\ApiController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class UserGetController extends ApiController
{
    public function __invoke(Security $security)
    {

        $user = $security->getUser();
        $userArray = ['id' => $user->getId(),
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'roles' => $user->getRoles(),
            'phone' => $user->getPhone()];
        if ($user instanceof UserInterface) {
            return $this->successResponse($userArray);
        }

        return $this->errorResponse();
    }
}
