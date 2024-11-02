<?php

namespace App\DTO;

use App\Entity\EntityInterface;

interface DTOInterface
{
    public function getEntity(): EntityInterface;
}
