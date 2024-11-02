<?php

namespace App\Service;

interface TranslateApiClientInterface
{
    public function trans(string $text): string;
}
