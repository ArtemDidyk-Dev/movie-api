<?php

namespace App\Controller\Api;

use App\Service\TranslateApiClientInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class TranslateController extends AbstractController
{
    public function __construct(
        public TranslateApiClientInterface $translateApiClient
    )
    {
    }

    #[Route('/translate', name: 'translate', methods: ['GET'])]
    public function translate(): JsonResponse
    {
        return new JsonResponse($this->translateApiClient->trans('View pages'));
    }
}
