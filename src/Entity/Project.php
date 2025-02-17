<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Employee>
     */
    #[ORM\ManyToMany(targetEntity: Employee::class, inversedBy: 'projects')]
    private Collection $teamList;

    public function __construct()
    {
        $this->teamList = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Employee>
     */
    public function getTeamList(): Collection
    {
        return $this->teamList;
    }

    public function addTeamList(Employee $teamList): static
    {
        if (!$this->teamList->contains($teamList)) {
            $this->teamList->add($teamList);
        }

        return $this;
    }

    public function removeTeamList(Employee $teamList): static
    {
        $this->teamList->removeElement($teamList);

        return $this;
    }
}
