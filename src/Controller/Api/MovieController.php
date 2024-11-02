<?php

namespace App\Controller\Api;

use App\Manager\MovieManager;
use App\Request\MovieRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Attribute\Route;

class MovieController extends AbstractController
{
    public function __construct(
        private MovieManager $movieManager,

    ) {
    }

    #[Route('/films', name: 'films', methods: ['GET'], format: 'json')]
    public function getList(
        #[MapQueryString]
        MovieRequest $request,
    ) {

        $data = $this->movieManager->save($request)->findRandom();

        return $this->json($data);
    }
}

http://localhost:8950/films?minRating=6.8&maxRating=6.9&minYear=2023&MaxYear=2023&minRevenue=1000000&maxRevenue=100000000&genre=Action&minRuntime=110&maxRuntime=180&originalLanguage=en&spokenLanguage=English&limit=30%27,
