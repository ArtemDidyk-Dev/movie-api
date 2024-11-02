<?php

namespace App\DTO;

use App\Entity\EntityInterface;
use App\Entity\Movie;
use App\Serializer\AccessGroup;
use DateTimeImmutable;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\Ignore;
#[Groups(AccessGroup::MOVIE_READ)]
final class MovieDTO implements DTOInterface
{
    public ?int $id = null;
    public string $title;
    public string $overview;
    public string $status;
    public bool $adult;
    public string $imageUrl;
    public float $aggregateRating;
    public int $voteCount;
    public DateTimeImmutable $releaseDate;
    public int $runtime;
    public array $genres;
    public int $movieId;

    #[Ignore]
    public function getEntity(): EntityInterface
    {
        return new Movie();
    }
}
