<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PaymentInstructionsRepository")
 */
class PaymentInstructions
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $instructions;

    /**
     * @ORM\Column(type="string", length=255)
     *
     *
     * @Assert\File(mimeTypes={ "image/png", "image/jpg", "image/jpeg", "image/gif", "application/pdf" })
     */
    private $voucherexample;

    public function getId()
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

    public function getInstructions(): ?string
    {
        return $this->instructions;
    }

    public function setInstructions(string $instructions): self
    {
        $this->instructions = $instructions;

        return $this;
    }

    public function getVoucherexample(): ?string
    {
        return $this->voucherexample;
    }

    public function setVoucherexample(string $voucherexample): self
    {
        $this->voucherexample = $voucherexample;

        return $this;
    }
}
