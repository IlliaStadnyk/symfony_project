<?php

namespace App\Entity;

use App\Repository\AccessTokenRepository;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: AccessTokenRepository::class)]
class AccessToken
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: "text")]
    private ?string $token = null;

    #[ORM\Column]
    private ?int $userId =null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "accessTokens")]
    private User $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): static
    {
        $this->token = $token;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): static
    {
        $this->userId = $userId;

        return $this;
    }
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @throws RandomException
     */
    public function __construct()
    {
        $this->token = bin2hex(random_bytes(32));
    }
    public function jsonSerialize(): array
    {
        return [
            "id" => $this->id,
            "token" => $this->token,
            "userId" => $this->userId,
            ];
    }
}
