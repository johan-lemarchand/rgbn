<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 */
class Project
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
    private ?string $title;

    /**
     * @ORM\Column(type="text")
     */
    private ?string $content;


    /**
     * @ORM\Column(type="datetime")
     */
    private ?\DateTimeInterface $date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="project")
     */
    private ?Category $category;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Images", mappedBy="project", cascade={"persist", "remove"})
     */
    private ArrayCollection $images;

    public function __construct()
    {
        $this->date = new \DateTime();
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }


    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|Images[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImages(Images $img): self
    {
        if (!$this->images->contains($img)) {
            $this->images[] = $img;
            $img->setProject($this);
        }

        return $this;
    }

    public function removeImages(Images $img): self
    {
        if ($this->images->contains($img)) {
            $this->images->removeElement($img);
            // set the owning side to null (unless already changed)
            if ($img->getProject() === $this) {
                $img->setProject(null);
            }
        }

        return $this;
    }
}
