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
       * @ORM\Column(type="simple_array")
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

    /**
     * @ORM\Column(type="boolean")
     */
    private $isvisible;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $size;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $sizeinconsole;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $console;


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

    public function getGenre(): ?array
    {
        return $this->Genre;
    }

    public function setGenre(array $Genre): self
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

    public function getIsvisible(): ?bool
    {
        return $this->isvisible;
    }

    public function setIsvisible(bool $isvisible): self
    {
        $this->isvisible = $isvisible;

        return $this;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(?string $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getSizeinconsole(): ?string
    {
        return $this->sizeinconsole;
    }

    public function setSizeinconsole(?string $sizeinconsole): self
    {
        $this->sizeinconsole = $sizeinconsole;

        return $this;
    }

    public function getConsole(): ?string
    {
        return $this->console;
    }

    public function setConsole(?string $console): self
    {
        $this->console = $console;

        return $this;
    }

}
