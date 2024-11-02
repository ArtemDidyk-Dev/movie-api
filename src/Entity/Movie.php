<?php
declare(strict_types=1);

namespace App\Entity;

use App\DTO\DTOInterface;
use App\DTO\MovieDTO;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity()]
#[ORM\Table(name: 'movies')]
#[ORM\Index(columns: ['title'], name: 'movie_title_idx')]
class Movie implements EntityInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING)]
    private string $title;

    #[ORM\Column(type: Types::TEXT)]
    private string $overview;

    #[ORM\Column(type: Types::STRING)]
    private string $status;

    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $adult;

    #[ORM\Column(type: Types::STRING)]
    private string $imageUrl;

    #[ORM\Column(type: Types::FLOAT)]
    private float $aggregateRating;

    #[ORM\Column(type: Types::INTEGER)]
    private int $voteCount;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: false)]
    private DateTimeImmutable $releaseDate;

    #[ORM\Column(type: Types::INTEGER)]
    private int $runtime;

    #[ORM\Column(type: Types::SIMPLE_ARRAY)]
    private array $genres;

    #[ORM\Column(type: Types::INTEGER, unique: true)]
    private int $movieId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): Movie
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): Movie
    {
        $this->title = $title;

        return $this;
    }

    public function getOverview(): string
    {
        return $this->overview;
    }

    public function setOverview(string $overview): Movie
    {
        $this->overview = $overview;

        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): Movie
    {
        $this->status = $status;

        return $this;
    }

    public function isAdult(): bool
    {
        return $this->adult;
    }

    public function setAdult(bool $adult): Movie
    {
        $this->adult = $adult;

        return $this;
    }

    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(string $imageUrl): Movie
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    public function getAggregateRating(): float
    {
        return $this->aggregateRating;
    }

    public function setAggregateRating(float $aggregateRating): Movie
    {
        $this->aggregateRating = $aggregateRating;

        return $this;
    }

    public function getVoteCount(): int
    {
        return $this->voteCount;
    }

    public function setVoteCount(int $voteCount): Movie
    {
        $this->voteCount = $voteCount;

        return $this;
    }

    public function getReleaseDate(): DateTimeImmutable
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(DateTimeImmutable $releaseDate): Movie
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    public function getRuntime(): int
    {
        return $this->runtime;
    }

    public function setRuntime(int $runtime): Movie
    {
        $this->runtime = $runtime;

        return $this;
    }

    public function getDTO(): DTOInterface
    {
        return new MovieDTO();
    }

    public function getGenres(): array
    {
        return array_unique($this->genres);
    }

    public function setGenres(array $genres): Movie
    {
        $this->genres = $genres;

        return $this;
    }

    public function addGenre(string $genre): Movie
    {
        $this->genres[] = $genre;

        return $this;
    }

    public function getMovieId(): int
    {
        return $this->movieId;
    }

    public function setMovieId(int $movieId): Movie
    {
        $this->movieId = $movieId;

        return $this;
    }
}
