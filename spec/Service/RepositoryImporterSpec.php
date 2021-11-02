<?php

declare(strict_types=1);

namespace spec\App\Service;

use PhpSpec\ObjectBehavior;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class RepositoryImporterSpec extends ObjectBehavior
{
    function let(HttpClientInterface $httpClient): void
    {
        $this->beConstructedWith($httpClient);
    }

    function it_implements_repository_importer_interface(): void
    {
        $this->shouldImplement(RepositoryImporterInterface::class);
    }

    function it_imports_data_from_given_repository(HttpClientInterface $httpClient): void
    {
        $httpClient->request('GET', 'https://api.github.com/users/rafikooo/repos')->willReturn(
            [
                [
                    'id' => 420,
                    'node_id' => 'NODE_ID',
                    'name' => 'NAME',
                ]
            ]
        );
        $this->import('github', 'rafikooo')->shouldReturn(
            [
                [
                    'id' => 420,
                    'node_id' => 'NODE_ID',
                    'name' => 'NAME',
                ]
            ]
        );
    }
}