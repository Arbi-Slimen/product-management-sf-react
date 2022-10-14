<?php

namespace App\Entity;

use App\Repository\ReviewRepository;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass=ReviewRepository::class)
 */
class Review
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"getDetailProduct"})
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"getDetailProduct"})
     */
    private $value;

    /**
     * @ORM\Column(type="text")
     * @Groups({"getDetailProduct"})
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="reviews")
     */
    private $product;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): self
    {
        $this->value = $value;

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

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }
}