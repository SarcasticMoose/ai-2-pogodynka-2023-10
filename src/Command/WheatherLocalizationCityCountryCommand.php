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
    name: 'wheather:localizationCityCountry',
    description: 'Add a short description for your command',
)]
class WheatherLocalizationCityCountryCommand extends Command
{
    private WeatherUtil $util;
    private LocationRepository $locationRepository;

    public function __construct(WeatherUtil $util,LocationRepository $locationRepository)
    {
        parent::__construct();
        $this->util = $util;
        $this->locationRepository = $locationRepository;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('countryCode', InputArgument::REQUIRED, 'for example: PL')
            ->addArgument('city', InputArgument::REQUIRED, 'for example: Szczecin')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $countryCode = $input->getArgument('countryCode');
        $cityId = $input->getArgument('city');

        $localization = $this->locationRepository->findOneBy([
            'country' => $countryCode,
            'city' => $cityId,
        ]);

        $measurements = $this->util->getWeatherForCountryAndCity($localization->getCountry(),$localization->getCity());

        $io->writeln(sprintf("Location name: %s)",$localization->getCity()));

        foreach ($measurements as $measure){
            $io->writeln(sprintf("\tData: %s, temp: %s (in Celsius)",
                $measure->getDate()->format("Y-d-m"),
                $measure->getCelsius()
            ));
        }
        return Command::SUCCESS;
    }
}
