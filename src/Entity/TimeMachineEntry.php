<?php

namespace App\Entity;

use App\Repository\TimeMachineEntryRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use App\Entity\Origin;

/**
 * @ORM\Entity(repositoryClass=TimeMachineEntryRepository::class)
 */
class TimeMachineEntry
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @ManyToOne(targetEntity="Origin")
     */
    private $origin;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getOrigin(): ?int
    {
        return $this->origin;
    }

    public function setOrigin(int $origin): self
    {
        $this->origin = $origin;

        return $this;
    }
}
