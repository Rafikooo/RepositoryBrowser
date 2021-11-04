<?php

namespace spec\App\Provider;

use App\Provider\GitLab;
use App\Provider\ProviderInterface;
use PhpSpec\ObjectBehavior;

class GitLabSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(GitLab::class);
    }

    function it_implements_provider_interface(): void
    {
        $this->shouldImplement(ProviderInterface::class);
    }
}
