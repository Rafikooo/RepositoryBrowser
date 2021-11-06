<?php

declare(strict_types=1);

namespace App\Provider;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class GitHub implements ProviderInterface
{
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function requestRepositories(string $organization): array
    {
        return [];
    }
}
