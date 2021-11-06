<?php

namespace spec\App\Provider;

use App\Provider\GitHub;
use App\Provider\GitLab;
use App\Provider\ProviderInterface;
use http\Client\Response;
use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class GitHubSpec extends ObjectBehavior
{
    function it_is_initializable(HttpClientInterface $client): void
    {
        $this->beConstructedWith($client);
        $this->shouldHaveType(GitHub::class);
    }

    function it_implements_provider_interface(HttpClientInterface $client): void
    {
        $this->beConstructedWith($client);
        $this->shouldImplement(ProviderInterface::class);
    }

    function it_throws_404_not_found_exception_if_organization_not_exists(HttpClientInterface $client, ResponseInterface $response): void
    {
        $this->beConstructedWith($client);
        $response->getStatusCode()->willReturn(404);
        $client->request(
            'GET',
            'https://api.github.com/users/not-existing-organization-name/repos'
        )->willReturn($response);

        $this->shouldThrow(NotFoundHttpException::class)
            ->during('requestRepositories', ['not-existing-organization-name']);
    }

    function it_should_return_an_array_of_repositories_if_organization_exists(HttpClientInterface $client, ResponseInterface $response): void
    {
        $this->beConstructedWith($client);
        $data = [
            [
                'id' => 2137,
                'node_id' => 'NODE_ID',
                'name' => 'NAME',
            ]
        ];

        $response->getStatusCode()->willReturn(200);
        $response->toArray()->willReturn($data);
        $client->request(
            'GET',
            'https://api.github.com/users/existing-organization-name/repos'
        )->willReturn($response);


        $this->requestRepositories('existing-organization-name')
            ->shouldReturn($data);
    }
}
