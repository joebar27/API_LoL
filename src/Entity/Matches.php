<?php

namespace App\Entity;

use App\Repository\MatchesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MatchesRepository::class)]
class Matches
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private array $matchesList = [];

    #[ORM\Column(length: 255)]
    private ?string $puuid = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatchesList(): array
    {
        return $this->matchesList;
    }

    public function setMatchesList(array $matchesList): self
    {
        $this->matchesList = $matchesList;

        return $this;
    }

    public function getPuuid(): ?string
    {
        return $this->puuid;
    }

    public function setPuuid(string $puuid): self
    {
        $this->puuid = $puuid;

        return $this;
    }
}
