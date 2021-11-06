<?php

declare(strict_types=1);

namespace spec\App\Service;

use App\Exception\ProviderNotExistsException;
use App\Provider\GitHub;
use App\Provider\GitLab;
use PhpSpec\ObjectBehavior;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ProviderProxySpec extends ObjectBehavior
{
    function it_should_contain_an_array_of_provider_interface(
        HttpClientInterface $client,
        GitHub $gitHub,
        GitLab $gitLab
    ): void
    {

        $this->beConstructedWith([$gitHub, $gitLab]);
        $this->getProviders()->shouldReturn([$gitHub, $gitLab]);
    }

    function it_should_throw_an_exception_if_given_provider_does_not_exists(
        HttpClientInterface $client,
        GitHub $gitHub,
        GitLab $gitLab
    ): void
    {
        $this->beConstructedWith([$gitHub, $gitLab]);
        $this->shouldThrow(ProviderNotExistsException::class)
            ->during('importRepositoryData', [
                'Rafikooo',
                'GutHib'
            ]);
    }

    function it_should_not_throw_an_exception_if_given_provider_does_exists(
        HttpClientInterface $client,
        GitHub $gitHub,
        GitLab $gitLab
    ): void
    {
        $this->beConstructedWith([
            $gitHub->beADoubleOf(GitHub::class),
            $gitLab->beADoubleOf(GitLab::class)
        ]);
        $this->shouldNotThrow(ProviderNotExistsException::class)
            ->during('importRepositoryData', [
                'Rafikooo',
                'GitHub'
            ]);
    }
}
