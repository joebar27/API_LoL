<?php

namespace App\Entity;

use App\Repository\TimelineMatchRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TimelineMatchRepository::class)]
class TimelineMatch
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private array $timelineDetail = [];

    #[ORM\Column(length: 255)]
    private ?string $matchId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTimelineDetail(): array
    {
        return $this->timelineDetail;
    }

    public function setTimelineDetail(array $timelineDetail): self
    {
        $this->timelineDetail = $timelineDetail;

        return $this;
    }

    public function getMatchId(): ?string
    {
        return $this->matchId;
    }

    public function setMatchId(string $matchId): self
    {
        $this->matchId = $matchId;

        return $this;
    }
}
