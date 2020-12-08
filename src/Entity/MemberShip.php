<?php

namespace App\Entity;

use App\Repository\MemberShipRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MemberShipRepository::class)
 */
class MemberShip
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
    private $type;

    /**
     * @ORM\Column(type="datetime")
     */
    private $beginAt;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    /**
     * @ORM\Column(type="integer")
     */
    private $amount;

    /**
     * @ORM\ManyToOne(targetEntity=Contact::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $member;

    /**
     * @ORM\OneToOne(targetEntity=Computer::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $computer;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $residual;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mode;




    public function __construct()
    {
        $this->beginAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getBeginAt(): ?\DateTimeInterface
    {
        return $this->beginAt;
    }

    public function setBeginAt(\DateTimeInterface $beginAt): self
    {
        $this->beginAt = $beginAt;

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

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getMember(): ?Contact
    {
        return $this->member;
    }

    public function setMember(?Contact $member): self
    {
        $this->member = $member;

        return $this;
    }

    public function getComputer(): ?Computer
    {
        return $this->computer;
    }

    public function setComputer(Computer $computer): self
    {
        $this->computer = $computer;

        return $this;
    }

    public function getResidual(): ?int
    {
        return $this->residual;
    }

    public function setResidual(?int $residual): self
    {
        $this->residual = $residual;

        return $this;
    }

    public function getMode(): ?string
    {
        return $this->mode;
    }

    public function setMode(?string $mode): self
    {
        $this->mode = $mode;

        return $this;
    }

    
}
