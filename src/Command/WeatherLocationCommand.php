<?php

namespace App\Command;

use App\Repository\LocationRepository;
use App\Service\WeatherUtil;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'weather:location',
    description: 'Add a short description for your command',
)]
class WeatherLocationCommand extends Command
{
    private readonly LocationRepository $repository;
    private readonly WeatherUtil $util;

    public function __construct(LocationRepository $repository, WeatherUtil $util, $name = null)
    {
        $this->util = $util;
        $this->repository = $repository;
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->addArgument('id', InputArgument::REQUIRED, 'Localization ID')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $locationId = $input->getArgument('id');

        $locationCity = $this->repository->find($locationId);

        $measurements = $this->util->getWeatherForLocation($locationCity);


        $io->writeln(sprintf("Location in: %s)",$locationCity->getCity()));

        foreach ($measurements as $measure){
            $io->writeln(sprintf("\tData: %s, temp: %s (in Celsius)",
                $measure->getDate()->format("Y-d-m"),
                $measure->getCelsius()
            ));
        }

        return Command::SUCCESS;
    }
}
