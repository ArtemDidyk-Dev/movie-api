<?php

namespace App\DTO;

class PropertyDTO
{
    public string $name;
    public string $type;
    public bool $dto = false;
    public ?object $transform = null;
    public bool $translatable = false;
}
