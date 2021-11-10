<?php

declare(strict_types=1);

namespace App\Provider;

use Symfony\Contracts\HttpClient\HttpClientInterface;

interface ProviderInterface
{
    public function __construct(HttpClientInterface $client);

    /**
     * @return ProviderInterface[]
     */
    public function requestRepositories(string $organization): array;

    public function supports(string $repository): bool;

    public function calcTrustPoints(int $commitsCount, int $pullRequestsCount, $stargazersCount): int;
}
