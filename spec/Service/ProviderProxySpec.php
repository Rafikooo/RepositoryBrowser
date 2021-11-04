<?php

declare(strict_types=1);

namespace spec\App\Service;

use App\Exception\ProviderNotExistsException;
use App\Provider\GitHub;
use App\Provider\GitLab;
use PhpSpec\ObjectBehavior;

class ProviderProxySpec extends ObjectBehavior
{
    function it_should_contain_an_array_of_provider_interface(): void
    {
        $github = new GitHub();
        $gitlab = new GitLab();

        $this->beConstructedWith([$github, $gitlab]);
        $this->getProviders()->shouldReturn([$github, $gitlab]);
    }

    function it_should_throw_an_exception_if_given_provider_does_not_exists(): void
    {
        $github = new GitHub();
        $gitlab = new GitLab();

        $this->beConstructedWith([$github, $gitlab]);
        $this->shouldThrow(ProviderNotExistsException::class)
            ->during('importRepositoryData', [
                'Rafikooo',
                'GutHib'
            ]);
    }

    function it_should_not_throw_an_exception_if_given_provider_does_exists(): void
    {
        $github = new GitHub();
        $gitlab = new GitLab();

        $this->beConstructedWith([$github, $gitlab]);
        $this->shouldNotThrow(ProviderNotExistsException::class)
            ->during('importRepositoryData', [
                'Rafikooo',
                'GitHub'
            ]);
    }

    function it_return_provider_classes(): void
    {
        $github = new GitHub();
        $gitlab = new GitLab();
        $this->beConstructedWith([$github, $gitlab]);

        $this->getProviderClasses()->shouldReturn([
            GitHub::class,
            GitLab::class,
        ]);
    }
}
