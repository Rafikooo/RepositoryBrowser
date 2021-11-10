<?php

declare(strict_types=1);

namespace App\Provider;

use App\Entity\Repo;
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

    /** @return ProviderInterface[] */
    public function requestRepositories(string $organization): array
    {
        $response = $this->client->request(
            'GET',
            sprintf('https://api.github.com/users/%s/repos', $organization)
        );

        if($response->getStatusCode() === Response::HTTP_NOT_FOUND) {
            throw new NotFoundHttpException();
        }

        foreach ($response->toArray() as $item) {
            $repo = new Repo();
            $repo->setName($item['name'])
                ->setFullName($item['full_name'])
                ->setTrustPoints($this->calcTrustPoints(1, 1, $item['stargazers_count']));
            $repos[] = $repo;
        }

        return $repos ?? [];
    }

    public function supports(string $repository): bool
    {
        return $repository === $this->supportedName;
    }


    public function calcTrustPoints(int $commitsCount, int $pullRequestsCount, $stargazersCount): int
    {
        // TODO
        return $stargazersCount;
    }
}
