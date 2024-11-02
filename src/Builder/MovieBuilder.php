<?php
declare(strict_types=1);

namespace App\Builder;

use App\Entity\Movie;

final readonly class MovieBuilder
{
    public function buildFromApi(array $data): array
    {
        $movies = [];
        foreach ($data as $movieData) {
            $movie = new Movie();
            $movie->setTitle($movieData['title']);
            $movie->setOverview($movieData['overview']);
            $movie->setStatus($movieData['status']);
            $movie->setAdult($movieData['adult']);
            $movie->setImageUrl($movieData['poster_path']);
            $movie->setAggregateRating($movieData['vote_average']);
            $movie->setVoteCount($movieData['vote_count']);
            $movie->setReleaseDate(new \DateTimeImmutable($movieData['release_date']));
            $movie->setRuntime($movieData['runtime']);
            $genresFromApi = explode(',', $movieData['genres']);
            foreach ($genresFromApi as $genre) {
                $movie->addGenre(trim($genre));
            }
            $movie->setMovieId($movieData['id']);
            $movies[] = $movie;
        }

        return $movies;
    }
}
