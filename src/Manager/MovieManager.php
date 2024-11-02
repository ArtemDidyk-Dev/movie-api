<?php

namespace App\Manager;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use App\Request\MovieRequest;
use App\Serializer\AccessGroup;
use App\Serializer\Mapper;
use App\Service\MovieApiClient;
use App\Service\TranslateApiClient;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;

final readonly class MovieManager
{
    public function __construct(
        private EntityManagerInterface $em,
        private MovieApiClient $movieApiClient,
        private MovieRepository $movieRepository,
        private TranslateApiClient $translateApiClient,
        private Mapper $mapper
    ) {

    }

    public function save(MovieRequest $movieRequest): self
    {
        $movies = $this->movieApiClient->getMovies($movieRequest);
        foreach ($movies as $movie) {
            /** @var Movie|null $movieFromDb */
            $movieFromDb = $this->em->getRepository(Movie::class)->findOneBy(['movieId' => $movie->getMovieId()]);
            if ($movieFromDb === null) {
                $this->em->persist($movie);
            }
        }
        $this->em->flush();
        return $this;
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findRandom()
    {

        /** @var Movie|null $movie */
        $movie = $this->movieRepository->findRandom();
        $movie->setOverview($this->translateApiClient->trans($movie->getOverview()));
        $this->em->flush();

        return $this->mapper->mapToModel($movie, AccessGroup::MOVIE_READ);
    }
}
