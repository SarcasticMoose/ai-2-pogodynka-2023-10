<?php

namespace App\Entity;

use App\Repository\CityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CityRepository::class)]
class City
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\Column(length: 255)]
    private ?string $Country = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 13, scale: 3)]
    private ?string $Longitude = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 13, scale: 3)]
    private ?string $Latitude = null;

    #[ORM\Column(length: 255)]
    private ?string $Region = null;

    #[ORM\OneToMany(mappedBy: 'city', targetEntity: Forecast::class)]
    private Collection $forecast;

    #[ORM\Column(length: 255)]
    private ?string $CountryCode = null;

    public function __construct()
    {
        $this->forecast = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->Country;
    }

    public function setCountry(string $Country): static
    {
        $this->Country = $Country;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->Longitude;
    }

    public function setLongitude(string $Longitude): static
    {
        $this->Longitude = $Longitude;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->Latitude;
    }

    public function setLatitude(string $Latitude): static
    {
        $this->Latitude = $Latitude;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->Region;
    }

    public function setRegion(string $Region): static
    {
        $this->Region = $Region;

        return $this;
    }

    /**
     * @return Collection<int, Forecast>
     */
    public function getForecast(): Collection
    {
        return $this->forecast;
    }

    public function addForecast(Forecast $forecast): static
    {
        if (!$this->forecast->contains($forecast)) {
            $this->forecast->add($forecast);
            $forecast->setCity($this);
        }

        return $this;
    }

    public function removeForecast(Forecast $forecast): static
    {
        if ($this->forecast->removeElement($forecast)) {
            // set the owning side to null (unless already changed)
            if ($forecast->getCity() === $this) {
                $forecast->setCity(null);
            }
        }

        return $this;
    }

    public function getCountryCode(): ?string
    {
        return $this->CountryCode;
    }

    public function setCountryCode(string $CountryCode): static
    {
        $this->CountryCode = $CountryCode;

        return $this;
    }
}
