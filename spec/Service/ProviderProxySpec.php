<?php

declare(strict_types=1);

namespace spec\App\Service;

use App\Exception\ProviderNotExistsException;
use App\Provider\GitHub;
use App\Provider\GitLab;
use App\Provider\ProviderInterface;
use Doctrine\ORM\EntityManagerInterface;
use PhpSpec\ObjectBehavior;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ProviderProxySpec extends ObjectBehavior
{
    function it_should_contain_an_array_of_provider_interface(
        EntityManagerInterface $entityManager,
        ProviderInterface $gitHub,
        ProviderInterface $gitLab
    ): void {
        $this->beConstructedWith([$gitHub, $gitLab], $entityManager);
        $this->getProviders()->shouldReturn([$gitHub, $gitLab]);
    }

    function it_should_throw_an_exception_if_given_provider_does_not_exists(
        EntityManagerInterface $entityManager,
        ProviderInterface $gitHub,
        ProviderInterface $gitLab
    ): void
    {
        $this->beConstructedWith([$gitHub, $gitLab], $entityManager);
        $gitLab->supports('GutHib')->willReturn(false);
        $gitHub->supports('GutHib')->willReturn(false);

        $this->shouldThrow(ProviderNotExistsException::class)
            ->during('importRepositoryData', [
                'Rafikooo',
                'GutHib'
            ]);
    }

    function it_should_not_throw_an_exception_if_given_provider_does_exists(
        EntityManagerInterface $entityManager,
        ProviderInterface $gitHub,
        ProviderInterface $gitLab
    ): void {
        $this->beConstructedWith(
            [$gitHub, $gitLab],
            $entityManager
        );
        $this->shouldNotThrow(ProviderNotExistsException::class)
            ->during('importRepositoryData', [
                'Rafikooo',
                'GitHub'
            ]);
    }
}
