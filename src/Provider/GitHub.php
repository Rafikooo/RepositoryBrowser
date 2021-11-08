<?php

declare(strict_types=1);

namespace App\Provider;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class GitHub implements ProviderInterface
{
    private string $supportedName = 'GitHub';

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

        if($response->getStatusCode() === Response::HTTP_NOT_FOUND) {
            throw new NotFoundHttpException();
        }

        return $response->toArray();
    }

    public function supports(string $repository): bool
    {
        return $repository === $this->supportedName;
    }
}
