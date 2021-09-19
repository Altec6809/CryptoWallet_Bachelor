<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=TransactionRepository::class)
 */
class Transaction
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
    private $cryptoName;

    /**
     * @Assert\NotBlank( message=" Veuillez remplir une quantité ")
     * @Assert\NotNull( message=" Veuillez remplir une quantité superieur à 0")
     * @ORM\Column(type="decimal", precision=10, scale=4)
     */
    private $quantity;

    /**
     * @Assert\NotBlank( message=" Veuillez remplir un prix d'achat ")
     * @Assert\NotNull( message=" Veuillez remplir une quantité superieur à 0")
     * @ORM\Column(type="decimal", precision=10, scale=4)
     */
    private $price;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCryptoName(): ?string
    {
        return $this->cryptoName;
    }

    public function setCryptoName(string $cryptoName): self
    {
        $this->cryptoName = $cryptoName;

        return $this;
    }

    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    public function setQuantity(float $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

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
}
