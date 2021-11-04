<?php

declare(strict_types=1);

namespace spec\App\Service;

use App\Provider\GitHub;
use App\Provider\GitLab;
use App\Provider\ProviderInterface;
use PhpSpec\ObjectBehavior;
use spec\App\Provider\GitHubSpec;

class ProviderProxySpec extends ObjectBehavior
{
    function it_should_contain_an_array_of_provider_interface(): void
    {
        $github = new GitHub();
        $gitlab = new GitLab();

        $this->beConstructedWith([$github, $gitlab]);
        $this->getProviders()->shouldReturn([$github, $gitlab]);
    }
}
