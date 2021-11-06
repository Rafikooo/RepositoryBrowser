<?php

namespace spec\App\Provider;

use App\Provider\GitLab;
use App\Provider\ProviderInterface;
use PhpSpec\ObjectBehavior;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GitLabSpec extends ObjectBehavior
{
    function it_is_initializable(HttpClientInterface $client)
    {
        $this->beConstructedWith($client);
        $this->shouldHaveType(GitLab::class);
    }

    function it_implements_provider_interface(HttpClientInterface $client): void
    {
        $this->beConstructedWith($client);
        $this->shouldImplement(ProviderInterface::class);
    }
}
