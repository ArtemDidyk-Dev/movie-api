<?php
declare(strict_types=1);

namespace App\Serializer;

class AccessGroup
{
    public const string MOVIE_READ = 'movie:read';
    public const string USER_READ = 'user:read';
    public const string USER_CREATE = 'user:create';
    public const string USER_UPDATE = 'user:update';
}
