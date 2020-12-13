<?php

namespace App\Entity;

use App\Repository\DataRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DataRepository::class)
 */
class Data
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
    private $membershipType;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $membershipValue;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMembershipType(): ?string
    {
        return $this->membershipType;
    }

    public function setMembershipType(string $membershipType): self
    {
        $this->membershipType = $membershipType;

        return $this;
    }

    public function getMembershipValue(): ?string
    {
        return $this->membershipValue;
    }

    public function setMembershipValue(string $membershipValue): self
    {
        $this->membershipValue = $membershipValue;

        return $this;
    }
}
