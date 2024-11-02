<?php

namespace App\Request;
use App\Enum\MovieGenre;
use Symfony\Component\Validator\Constraints as Assert;

final class MovieRequest
{
    #[Assert\Type('float')]
    public ?float $minRating = 7.1;

    #[Assert\Type('float')]
    public ?float $maxRating = 9.0;

    #[Assert\Type('int')]
    public ?int $minYear = 2010;

    #[Assert\Type('int')]
    public ?int $maxYear = 2023;

    #[Assert\Type('int')]
    public ?int $minRevenue = 100;

    #[Assert\Type('int')]
    public ?int $maxRevenue = 100000000;

    public MovieGenre $genre = MovieGenre::Action;

    #[Assert\Type('int')]
    public ?int $minRuntime = 110;

    #[Assert\Type('int')]
    public ?int $maxRuntime = 180;

    #[Assert\Type('int')]
    public int $limit = 30;

}
