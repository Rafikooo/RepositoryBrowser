<?php

namespace spec\App\Provider;

use App\Provider\GitHub;
use App\Provider\ProviderInterface;
use PhpSpec\ObjectBehavior;

class GitHubSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(GitHub::class);
    }

    function it_implements_provider_interface(): void
    {
        $this->shouldImplement(ProviderInterface::class);
    }
}
