<?php

namespace App\Entity;

use App\Repository\ProjectsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProjectsRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Projects
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     *
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="project")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\OneToMany (targetEntity=Image::class, mappedBy="projects", cascade={"persist","remove"})
     */
    private  $image;


    /**
     * @ORM\OneToOne(targetEntity=ImageBefore::class, mappedBy="imgBefore", cascade={"persist", "remove"})
     */
    private $imageBefore;

    /**
     * @ORM\OneToOne(targetEntity=ImageAfter::class, mappedBy="imgAfter", cascade={"persist", "remove"})
     */
    private $imageAfter;



    public function __construct()
    {
        $this->image = new ArrayCollection();
    }
    public function toString()
    {
        return $this->image;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @ORM\PrePersist
     * @return Projects
     */
    public function setCreatedAt(): self
    {
        $this->createdAt = new \DateTime();

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
     * @return Collection|image[]
     */
    public function getImage(): Collection
    {
        return $this->image;
    }


    public function addImage(?image $image): self
    {
        if ($image && !$this->image->contains($image)) {
            $this->image[] = $image;
            $image->setProjects($this);
        }

        return $this;
    }

    public function removeProject(image $image): self
    {
        if ($this->image->contains($image)) {
            $this->image->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getProjects() === $this) {
                $image->setProjects(null);
            }
        }

        return $this;
    }



    public function getImageBefore(): ?ImageBefore
    {
        return $this->imageBefore;
    }

    public function setImageBefore(?ImageBefore $imageBefore): self
    {
        $this->imageBefore = $imageBefore;

        // set (or unset) the owning side of the relation if necessary
        $newImgBefore = null === $imageBefore ? null : $this;
        if ($imageBefore && $imageBefore->getImgBefore() !== $newImgBefore) {
            $imageBefore->setImgBefore($newImgBefore);
        }

        return $this;
    }

    public function getImageAfter(): ?ImageAfter
    {
        return $this->imageAfter;
    }

    public function setImageAfter(?ImageAfter $imageAfter): self
    {
        $this->imageAfter = $imageAfter;

        // set (or unset) the owning side of the relation if necessary
        $newImgAfter = null === $imageAfter ? null : $this;
        if ($imageAfter && $imageAfter->getImgAfter() !== $newImgAfter) {
            $imageAfter->setImgAfter($newImgAfter);
        }

        return $this;
    }


}
