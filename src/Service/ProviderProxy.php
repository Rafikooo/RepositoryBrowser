<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\ProviderNotExistsException;
use App\Provider\ProviderInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ProviderProxy
{
    /**
     * @var ProviderInterface[]
     */
    private iterable $providers;

    public function __construct(iterable $providers)
    {
        $this->providers = $providers;
    }

    public function getProviders(): iterable
    {
        return $this->providers;
    }

    public function importRepositoryData(string $organization, string $provider): void
    {
        $reflector = new \ReflectionClass(ProviderInterface::class);
        $givenProvider = sprintf('%s\\%s', $reflector->getNamespaceName(), $provider);
        $providers = $this->getProviderClasses();
        if(!in_array($givenProvider, $providers)) {
            throw new ProviderNotExistsException();
        }
        foreach($this->providers as $provider) {
            if($provider::class === $givenProvider) {
                $repositories = $provider->requestRepositories($organization);
                dd($repositories);
            }
        }

    }

    public function getProviderClasses(bool $withNamespace = true)
    {
        foreach ($this->providers as $provider) {
            $result[] = $withNamespace ? $provider::class : (new \ReflectionClass($provider))->getShortName();
        }

        return $result ?? [];
    }
}
