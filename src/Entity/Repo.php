<?php

namespace App\Entity;

use App\Repository\RepoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RepoRepository::class)
 */
class Repo
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
    private $fullName;

    /**
     * @ORM\Column(type="integer")
     */
    private $trustPoints;

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

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getStargazersCount(): ?int
    {
        return $this->stargazersCount;
    }

    public function setStargazersCount(int $stargazersCount): self
    {
        $this->stargazersCount = $stargazersCount;

        return $this;
    }

    public function getTrustPoints(): ?int
    {
        return $this->trustPoints;
    }

    public function setTrustPoints(int $trustPoints): self
    {
        $this->trustPoints = $trustPoints;

        return $this;
    }
}
