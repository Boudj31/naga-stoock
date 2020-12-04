<?php

namespace App\Entity;

use App\Repository\SocietyRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SocietyRepository::class)
 */
class Society
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $representativeName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $representativeMail;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $representativePhone;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    /**
     * @ORM\OneToOne(targetEntity=Adress::class, inversedBy="society", cascade={"persist", "remove"})
     */
    private $adress;

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

    public function getRepresentativeName(): ?string
    {
        return $this->representativeName;
    }

    public function setRepresentativeName(?string $representativeName): self
    {
        $this->representativeName = $representativeName;

        return $this;
    }

    public function getRepresentativeMail(): ?string
    {
        return $this->representativeMail;
    }

    public function setRepresentativeMail(?string $representativeMail): self
    {
        $this->representativeMail = $representativeMail;

        return $this;
    }

    public function getRepresentativePhone(): ?string
    {
        return $this->representativePhone;
    }

    public function setRepresentativePhone(?string $representativePhone): self
    {
        $this->representativePhone = $representativePhone;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getAdress(): ?Adress
    {
        return $this->adress;
    }

    public function setAdress(?Adress $adress): self
    {
        $this->adress = $adress;

        return $this;
    }
}
