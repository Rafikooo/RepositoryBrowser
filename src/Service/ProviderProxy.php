<?php

declare(strict_types=1);

namespace App\Service;

use App\Provider\ProviderInterface;

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


}
