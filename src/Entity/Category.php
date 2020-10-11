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
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Projects::class, mappedBy="category")
     */
    private $project;

    /**
     * @ORM\OneToOne(targetEntity=Image::class, mappedBy="category", cascade={"persist", "remove"})
     */
    private $image;

    public function __construct()
    {
        $this->project = new ArrayCollection();
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

    /**
     * @return Collection|Projects[]
     */
    public function getProject(): Collection
    {
        return $this->project;
    }

    public function addProject(Projects $project): self
    {
        if (!$this->project->contains($project)) {
            $this->project[] = $project;
            $project->setCategory($this);
        }

        return $this;
    }

    public function removeProject(Projects $project): self
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

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): self
    {
        $this->image = $image;

        // set (or unset) the owning side of the relation if necessary
        $newCategory = null === $image ? null : $this;
        if ($image->getCategory() !== $newCategory) {
            $image->setCategory($newCategory);
        }

        return $this;
    }
}
