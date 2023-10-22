<?php

namespace App\Entity;

use App\Repository\ForecastRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ForecastRepository::class)]
class Forecast
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $ProbabilityOfPrecipitation = null;

    #[ORM\Column(length: 255)]
    private ?string $Cloudy = null;

    #[ORM\Column]
    private ?int $Wind = null;

    #[ORM\Column]
    private ?float $Temperature = null;

    #[ORM\Column]
    private ?int $Humidity = null;

    #[ORM\Column]
    private ?int $AmountOfPrecipitation = null;

    #[ORM\ManyToOne(inversedBy: 'forecast')]
    private ?City $city = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $Date = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProbabilityOfPrecipitation(): ?int
    {
        return $this->ProbabilityOfPrecipitation;
    }

    public function setProbabilityOfPrecipitation(int $ProbabilityOfPrecipitation): static
    {
        $this->ProbabilityOfPrecipitation = $ProbabilityOfPrecipitation;

        return $this;
    }

    public function getCloudy(): ?string
    {
        return $this->Cloudy;
    }

    public function setCloudy(string $Cloudy): static
    {
        $this->Cloudy = $Cloudy;

        return $this;
    }

    public function getWind(): ?int
    {
        return $this->Wind;
    }

    public function setWind(int $Wind): static
    {
        $this->Wind = $Wind;

        return $this;
    }

    public function getTemperature(): ?float
    {
        return $this->Temperature;
    }

    public function setTemperature(float $Temperature): static
    {
        $this->Temperature = $Temperature;

        return $this;
    }

    public function getHumidity(): ?int
    {
        return $this->Humidity;
    }

    public function setHumidity(int $Humidity): static
    {
        $this->Humidity = $Humidity;

        return $this;
    }

    public function getAmountOfPrecipitation(): ?int
    {
        return $this->AmountOfPrecipitation;
    }

    public function setAmountOfPrecipitation(int $AmountOfPrecipitation): static
    {
        $this->AmountOfPrecipitation = $AmountOfPrecipitation;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }


    public function setDate(\DateTimeInterface $Date): static
    {
        $this->Date = $Date;

        return $this;
    }
}
