<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $photo;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Project", mappedBy="category")
     */
    private $project;

    /**
     * @ORM\OneToOne(targetEntity=Images::class, mappedBy="category", cascade={"persist", "remove"})
     */
    private $img;

    public function __construct()
    {

    }

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

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * @return Collection|project[]
     */
    public function getProject(): Collection
    {
        return $this->project;
    }

    public function addProject(project $project): self
    {
        if (!$this->project->contains($project)) {
            $this->project[] = $project;
            $project->setCategory($this);
        }

        return $this;
    }

    public function removeProject(project $project): self
    {
        if ($this->project->contains($project)) {
            $this->project->removeElement($project);
            // set the owning side to null (unless already changed)
            if ($project->getCategory() === $this) {
                $project->setCategory(null);
            }
        }

        return $this;
    }

    public function getImg(): ?Images
    {
        return $this->img;
    }

    public function setImg(Images $img): self
    {
        $this->img = $img;

        // set the owning side of the relation if necessary
        if ($img->getCategory() !== $this) {
            $img->setCategory($this);
        }

        return $this;
    }
}
