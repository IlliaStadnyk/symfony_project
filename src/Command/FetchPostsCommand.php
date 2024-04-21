<?php

namespace App\Command;

use App\Entity\Post;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'FetchPostsCommand',
    description: 'Add a short description for your command',
)]
class FetchPostsCommand extends Command
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $httpClient = HttpClient::create();
        $responsePost = $httpClient->request('GET', 'https://jsonplaceholder.typicode.com/posts');
        $postsData = $responsePost->toArray();
        $responseUsers = $httpClient->request('GET', 'https://jsonplaceholder.typicode.com/users');
        $usersData = $responseUsers->toArray();
        $password = '12345678';

        foreach ($usersData as $userData) {

            $user = new User();
            $user->setId($userData['id']);
            $user->setName($userData['name']);
            $user->setUsername($userData['username']);
            $user->setPhone($userData['phone']);
            $user->setEmail($userData['email']);
            $user->setRoles(['ROLE_USER']);
            $hashedPassword = $this->passwordHasher->hashPassword($user, $password);
            $user->setPassword($hashedPassword);

            $this->entityManager->persist($user);
        }

        $this->entityManager->flush();

        foreach ($postsData as $postData) {
            $user = $this->entityManager->getRepository(User::class)->findOneBy(['id' => $postData['userId']]);
            $post = new Post();
            $post->setId($postData['id']);
            $post->setTitle($postData['title']);
            $post->setBody($postData['body']);
            $post->setUser($user);
            $post->setName($user->getName());

            $this->entityManager->persist($post);
        }

        $this->entityManager->flush();

        $output->writeln('Posts saved to db :)');

        return Command::SUCCESS;
    }
}
