<?php

namespace App\Entity;
use App\Repository\PartnerRepository;
use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass=PartnerRepository::class)
 */
class Partner
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $name;


    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $content;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $phone;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Images", mappedBy="partner", cascade={"persist", "remove"})
     */
    private  ArrayCollection $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }



    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return Collection|Images[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Images $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setPartner($this);
        }

        return $this;
    }

    public function removeImage(Images $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getPartner() === $this) {
                $image->setPartner(null);
            }
        }

        return $this;
    }
}
