<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\ProviderNotExistsException;
use App\Provider\ProviderInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ProviderProxy
{
    /**
     * @var ProviderInterface[]
     */
    private iterable $providers;
    private EntityManagerInterface $entityManager;

    public function __construct(iterable $providers, EntityManagerInterface  $entityManager)
    {
        $this->providers = $providers;
        $this->entityManager = $entityManager;
    }

    public function getProviders(): iterable
    {
        return $this->providers;
    }

    public function importRepositoryData(string $organization, string $provider): void
    {
        /** @var ProviderInterface $providerObject */
        foreach ($this->providers as $providerObject) {
            if ($providerObject->supports($provider)) {
                dd($providerObject->requestRepositories($organization));
            }
        }

        throw new ProviderNotExistsException();
    }

    public function getProviderClasses(bool $withNamespace = true)
    {
        foreach ($this->providers as $provider) {
            $result[] = $withNamespace ? $provider::class : (new \ReflectionClass($provider))->getShortName();
        }

        return $result ?? [];
    }
}
