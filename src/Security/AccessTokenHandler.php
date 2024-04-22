<?php
namespace App\Security;

use App\Entity\AccessToken;
use App\Repository\AccessTokenRepository;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Security\Http\AccessToken\AccessTokenHandlerInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;

class AccessTokenHandler implements AccessTokenHandlerInterface
{
    public function __construct(private AccessTokenRepository $accessTokenRepository)
    {

    }

    public function getUserBadgeFrom(#[\SensitiveParameter] string $accessToken): UserBadge
    {

        /** @var AccessToken $token */
        $token = $this->accessTokenRepository->findOneBy(['token' => $accessToken]);

        if (!$token) {
            throw new BadRequestHttpException('Access token not found');
        }

        return new UserBadge($token->getUser()->getUserIdentifier());
    }
}