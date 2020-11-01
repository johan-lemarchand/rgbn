<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;



/**
 * @ORM\Entity(repositoryClass=ImageRepository::class)
 */
class Image
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
     * @ORM\OneToOne(targetEntity=Category::class, inversedBy="image", cascade={"persist"})
     */
    private $category;

    /**
     * @ORM\ManyToOne (targetEntity=Projects::class, inversedBy="image", cascade={"remove"})
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $projects;

    /**
     * @ORM\OneToOne(targetEntity=Partner::class, inversedBy="image", cascade={"persist"})
     */
    private $partner;

    /**
     * @ORM\OneToOne(targetEntity=Projects::class, mappedBy="imgAfter", cascade={"persist", "remove"})
     */
    private $imgAfter;

    /**
     * @ORM\OneToOne(targetEntity=Projects::class, mappedBy="imgBefore", cascade={"persist", "remove"})
     */
    private $imgBefore;



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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
    public function getProjects(): ?Projects
    {
        return $this->projects;
    }

    public function setProjects(?Projects $projects): self
    {
        $this->projects = $projects;

        return $this;
    }



    public function getPartner(): ?Partner
    {
        return $this->partner;
    }

    public function setPartner(?Partner $partner): self
    {
        $this->partner = $partner;

        return $this;
    }

    public function getImgAfter(): ?Projects
    {
        return $this->imgAfter;
    }

    public function setImgAfter(?Projects $imgAfter): self
    {
        $this->imgAfter = $imgAfter;

        // set (or unset) the owning side of the relation if necessary
        $newImgAfter = null === $imgAfter ? null : $this;
        if ($imgAfter->getImgAfter() !== $newImgAfter) {
            $imgAfter->setImgAfter($newImgAfter);
        }

        return $this;
    }

    public function getImgBefore(): ?Projects
    {
        return $this->imgBefore;
    }

    public function setImgBefore(?Projects $imgBefore): self
    {
        $this->imgBefore = $imgBefore;

        // set (or unset) the owning side of the relation if necessary
        $newImgBefore = null === $imgBefore ? null : $this;
        if ($imgBefore->getImgBefore() !== $newImgBefore) {
            $imgBefore->setImgBefore($newImgBefore);
        }

        return $this;
    }


}
