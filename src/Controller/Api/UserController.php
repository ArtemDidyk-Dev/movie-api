<?php declare(strict_types=1);

namespace App\Controller\Api;

use App\DTO\UserDTO;
use App\Manager\UserManager;
use App\Serializer\AccessGroup;
use App\Serializer\Mapper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController
{
    public function __construct(
        private UserManager $userManager,
        private Mapper $mapper,
    )
    {
    }

    #[Route('/user', name: 'user', methods: ['POST'])]
    public function createUser(
        #[MapRequestPayload(
            serializationContext: [
                'groups' => [AccessGroup::USER_CREATE],
            ],
            validationGroups: [AccessGroup::USER_CREATE]
        )]
        UserDTO $userDTO
    )
    {
        $user = $this->userManager->createUser($userDTO);
        return $this->json($this->mapper->mapToModel($user, AccessGroup::USER_READ));
    }
}
