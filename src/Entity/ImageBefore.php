<?php

namespace App\Entity;

use App\Repository\ImageBeforeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ImageBeforeRepository::class)
 */
class ImageBefore
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
     * @ORM\OneToOne(targetEntity=Projects::class, inversedBy="imageBefore", cascade={"persist"})
     * @ORM\JoinColumn(onDelete="CASCADE")
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

    public function getImgBefore(): ?Projects
    {
        return $this->imgBefore;
    }

    public function setImgBefore(?Projects $imgBefore): self
    {
        $this->imgBefore = $imgBefore;

        return $this;
    }
}
