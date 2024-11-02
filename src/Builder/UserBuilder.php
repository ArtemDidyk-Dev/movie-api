<?php
declare(strict_types=1);

namespace App\Builder;

use App\DTO\UserDTO;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final readonly class UserBuilder
{
    public function __construct(
        private UserPasswordHasherInterface $hasher,
    ) {
    }

    public function build(UserDTO $userDTO): User
    {
        $user = new User();
        $user->setEmail($userDTO->email)
            ->setFirstName($userDTO->firstName)
            ->setLastName($userDTO->lastName)
            ->setRoles(['ROLE_USER'])
            ->setPlainPassword($userDTO->password)
            ->setPassword($this->hasher->hashPassword($user, $user->getPlainPassword()));
        return $user;
    }
}
