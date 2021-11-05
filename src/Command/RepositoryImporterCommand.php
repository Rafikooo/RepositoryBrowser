<?php

namespace App\Command;

use App\Exception\ProviderNotExistsException;
use App\Provider\ProviderInterface;
use App\Service\ProviderProxy;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:repository-importer',
    description: 'Import external repositories to app',
)]
class RepositoryImporterCommand extends Command
{
    private ProviderProxy $providerProxy;

    public function __construct(ProviderProxy $providerProxy)
    {
        $this->providerProxy = $providerProxy;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('organization', InputArgument::REQUIRED, 'Name of organization')
            ->addArgument('provider', InputArgument::REQUIRED, 'Name of provider')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $organization = $input->getArgument('organization');
        $provider = $input->getArgument('provider');

        try {
            $this->providerProxy->importRepositoryData($organization, $provider);
            $io->success('Imported successfully!');
        } catch (ProviderNotExistsException $e) {
            $io->warning('Given provider is not supported');
            $providers = $this->providerProxy->getProviderClasses(false);
            $provider = $io->choice("Select one of available", $providers);
            $this->providerProxy->importRepositoryData($organization, $provider);
        }

        return Command::SUCCESS;
    }
}
