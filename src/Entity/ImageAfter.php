<?php

namespace App\Entity;

use App\Repository\ImageAfterRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ImageAfterRepository::class)
 */
class ImageAfter
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
     * @ORM\OneToOne(targetEntity=Projects::class, inversedBy="imageAfter", cascade={"persist"})
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $imgAfter;

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

    public function getImgAfter(): ?Projects
    {
        return $this->imgAfter;
    }

    public function setImgAfter(?Projects $imgAfter): self
    {
        $this->imgAfter = $imgAfter;

        return $this;
    }
}
