<?php

declare(strict_types=1);

namespace App\Provider;

use Symfony\Contracts\HttpClient\HttpClientInterface;

interface ProviderInterface
{
    public function __construct(HttpClientInterface $client);
    public function requestRepositories(string $organization): array;
}
