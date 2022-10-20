<?php

namespace App\Entity;

use App\Repository\SummonersRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SummonersRepository::class)]
class Summoners
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private array $summonnersDetail = [];

    #[ORM\Column(length: 255)]
    private ?string $summonerName = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSummonnersDetail(): array
    {
        return $this->summonnersDetail;
    }

    public function setSummonnersDetail(array $summonnersDetail): self
    {
        $this->summonnersDetail = $summonnersDetail;

        return $this;
    }

    public function getSummonerName(): ?string
    {
        return $this->summonerName;
    }

    public function setSummonerName(string $summonerName): self
    {
        $this->summonerName = $summonerName;

        return $this;
    }
}
