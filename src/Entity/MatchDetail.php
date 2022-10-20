<?php

namespace App\Entity;

use App\Repository\MatchDetailRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MatchDetailRepository::class)]
class MatchDetail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private array $matchDetail = [];

    #[ORM\Column(length: 255)]
    private ?string $summonerNameList = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatchDetail(): array
    {
        return $this->matchDetail;
    }

    public function setMatchDetail(array $matchDetail): self
    {
        $this->matchDetail = $matchDetail;

        return $this;
    }

    public function getSummonerNameList(): ?string
    {
        return $this->summonerNameList;
    }

    public function setSummonerNameList(string $summonerNameList): self
    {
        $this->summonerNameList = $summonerNameList;

        return $this;
    }
}
