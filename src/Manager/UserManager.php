<?php declare(strict_types=1);

namespace App\Manager;

use App\Builder\UserBuilder;
use App\DTO\UserDTO;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

final readonly class UserManager
{
    public function __construct(
        private EntityManagerInterface $em,
        private UserBuilder $userBuilder,
    ) {
    }

    public function createUser(UserDTO $userDTO): User
    {
        $user = $this->userBuilder->build($userDTO);
        $user->eraseCredentials();
        $this->em->persist($user);
        $this->em->flush();
        return $user;
    }
}
