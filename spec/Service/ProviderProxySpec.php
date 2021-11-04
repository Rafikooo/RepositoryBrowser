<?php

declare(strict_types=1);

namespace spec\App\Service;

use App\Provider\ProviderInterface;
use PhpSpec\Exception\Example\FailureException;
use PhpSpec\ObjectBehavior;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ProviderProxySpec extends ObjectBehavior
{
    function it_should_contain_an_array_of_provider_interface(): void
    {
        $providers = ProviderInterface::class;
        $this->beConstructedWith($providers);
//        $this->getProviders()->shouldReturnAnArrayOfProviderInterface();
    }
}
