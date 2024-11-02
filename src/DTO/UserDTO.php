<?php

namespace App\DTO;

use App\Entity\EntityInterface;
use App\Entity\User;
use App\Serializer\AccessGroup;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\Ignore;
use Symfony\Component\Validator\Constraints\Email;

class UserDTO implements DTOInterface
{
    #[Groups([AccessGroup::USER_READ, AccessGroup::USER_UPDATE])]
    public ?int $id;

    #[Groups([AccessGroup::USER_CREATE, AccessGroup::USER_READ, AccessGroup::USER_UPDATE])]
    public string $firstName;

    #[Groups([AccessGroup::USER_CREATE, AccessGroup::USER_READ, AccessGroup::USER_UPDATE])]
    public string $lastName;


    #[Groups([AccessGroup::USER_CREATE, AccessGroup::USER_READ])]
    public string $email;

    #[Groups([AccessGroup::USER_CREATE, AccessGroup::USER_UPDATE])]
    public string $password;

    #[Groups([AccessGroup::USER_CREATE, AccessGroup::USER_UPDATE, AccessGroup::USER_READ])]
    public ?array $roles;

    #[Ignore]
    public function getEntity(): EntityInterface
    {
        return new User();
    }
}
