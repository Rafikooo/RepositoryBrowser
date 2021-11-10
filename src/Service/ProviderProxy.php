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
        $providerObject = $this->getSupportedProviderObject($provider);
        $repos = $providerObject->requestRepositories($organization);
        foreach ($repos as $repo) {
            $this->entityManager->persist($repo);
        }
        $this->entityManager->flush();
    }

    public function getProviderClasses(bool $withNamespace = true)
    {
        foreach ($this->providers as $provider) {
            $result[] = $withNamespace ? $provider::class : (new \ReflectionClass($provider))->getShortName();
        }

        return $result ?? [];
    }

    private function getSupportedProviderObject(string $provider): ProviderInterface
    {
        foreach ($this->providers as $providerObject) {
            if($providerObject->supports($provider)) {
                return $providerObject;
            }
        }

        throw new ProviderNotExistsException();
    }
}
