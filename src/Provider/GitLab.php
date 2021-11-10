<?php

declare(strict_types=1);

namespace App\Provider;

use Symfony\Contracts\HttpClient\HttpClientInterface;

final class GitLab implements ProviderInterface
{
    private string $supportedName = 'GitLab';

    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function requestRepositories(string $organization): array
    {
        return [];
    }

    public function supports(string $repository): bool
    {
        return $repository === $this->supportedName;
    }

    public function calcTrustPoints(int $commitsCount, int $pullRequestsCount, $stargazersCount): int
    {
        return 0;
    }
}
