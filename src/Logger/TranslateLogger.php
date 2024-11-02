<?php
declare(strict_types=1);

namespace App\Logger;

use Monolog\Attribute\WithMonologChannel;
use Psr\Log\LoggerInterface;

#[WithMonologChannel('translation')]
final readonly class TranslateLogger
{
    public function __construct(
        private LoggerInterface $logger
    ) {
    }

    public function log(string|\Stringable $message, array $context = []): void
    {
        $this->logger->info($message, $context);
    }
}
