<?php

namespace App\Entity;

use App\Repository\PartnerRepository;
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
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone;

    /**
     * @ORM\OneToOne(targetEntity=Image::class, mappedBy="partner", cascade={"persist", "remove"})
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $link;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $activityOne;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $activityTwo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $activityThree;

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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

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
        $newPartner = null === $image ? null : $this;
        if ($image && $image->getPartner() !== $newPartner) {
            $image->setPartner($newPartner);
        }

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getActivityOne(): ?string
    {
        return $this->activityOne;
    }

    public function setActivityOne(?string $activityOne): self
    {
        $this->activityOne = $activityOne;

        return $this;
    }

    public function getActivityTwo(): ?string
    {
        return $this->activityTwo;
    }

    public function setActivityTwo(?string $activityTwo): self
    {
        $this->activityTwo = $activityTwo;

        return $this;
    }

    public function getActivityThree(): ?string
    {
        return $this->activityThree;
    }

    public function setActivityThree(?string $activityThree): self
    {
        $this->activityThree = $activityThree;

        return $this;
    }
}
