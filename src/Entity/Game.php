<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GameRepository")
 */
class Game
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     *
     * @Assert\File(mimeTypes={ "image/png", "image/jpg", "image/jpeg", "image/gif", "application/pdf" })
     */
    private $Cover;

    /**
     * @ORM\Column(type="integer")
     */
    private $DiscountPercentage;

    /**
     * @ORM\Column(type="integer")
     */
    private $OriginalPrice;

    /**
     * @ORM\Column(type="integer")
     */
    private $FinalPrice;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Title;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $Target;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $Genre;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $Description;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCover(): ?string
    {
        return $this->Cover;
    }

    public function setCover(string $Cover): self
    {
        $this->Cover = $Cover;

        return $this;
    }

    public function getDiscountPercentage(): ?int
    {
        return $this->DiscountPercentage;
    }

    public function setDiscountPercentage(int $DiscountPercentage): self
    {
        $this->DiscountPercentage = $DiscountPercentage;

        return $this;
    }

    public function getOriginalPrice(): ?int
    {
        return $this->OriginalPrice;
    }

    public function setOriginalPrice(int $OriginalPrice): self
    {
        $this->OriginalPrice = $OriginalPrice;

        return $this;
    }

    public function getFinalPrice(): ?int
    {
        return $this->FinalPrice;
    }

    public function setFinalPrice(int $FinalPrice): self
    {
        $this->FinalPrice = $FinalPrice;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): self
    {
        $this->Title = $Title;

        return $this;
    }

    public function getTarget(): ?string
    {
        return $this->Target;
    }

    public function setTarget(string $Target): self
    {
        $this->Target = $Target;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->Genre;
    }

    public function setGenre(string $Genre): self
    {
        $this->Genre = $Genre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }
}
