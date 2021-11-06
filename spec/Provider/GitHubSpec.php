<?php

namespace spec\App\Provider;

use App\Provider\GitHub;
use App\Provider\ProviderInterface;
use PhpSpec\ObjectBehavior;
use Symfony\Contracts\HttpClient\HttpClientInterface;

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


}
