<?php

declare(strict_types=1);

namespace App\Provider;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
        $response = $this->client->request(
            'GET',
            sprintf('https://api.github.com/users/%s/repos', $organization)
        );

        if($response->getStatusCode() === 404) {
            throw new NotFoundHttpException();
        }

        return $response->toArray();
    }
}
