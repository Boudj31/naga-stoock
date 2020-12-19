<?php

namespace App\Entity;

use App\Repository\ComputerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ComputerRepository::class)
 */
class Computer
{
    CONST GIVEN = 'Donné';
    CONST ASSO = 'Donné asso';
    CONST STOCK = 'En stock';
    CONST BREAK = 'Démonté';

    CONST FIXE = 'PC Fixe';
    CONST LAPTOP = 'PC Portable';
    CONST SERVER = 'Serveur';


    public const TYPE_STATUS = [
        'donné' => self::GIVEN,
        'asso' => self::ASSO,
        'dispo' => self::STOCK,
        'démonté' => self::BREAK
    ];
    

    public const TYPE_VALUES = [
        'fixe' => self::FIXE,
        'portable' => self::LAPTOP,
        'serveur' => self::SERVER
    ];

    public static function getTypeName(string $type): string
    {
        if (!in_array($type, self::TYPE_STATUS)) {
            throw new \InvalidArgumentException($type.' is not a valid computer status');
        }

        return 'computer.type.values.'.$type;
    }

    public static function getStatusName(string $status): string
    {
        if (!in_array($status, self::TYPE_VALUES)) {
            throw new \InvalidArgumentException($status.' is not a valid computer status');
        }

        return 'computer.status.values.'.$status;
    }
    

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $receivedAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $serial;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=Society::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $donor;

    /**
     * @ORM\OneToOne(targetEntity=MemberShip::class, cascade={"persist", "remove"})
     */
    private $member;

    public function __construct()
    {
        $this->receivedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReceivedAt(): ?\DateTimeInterface
    {
        return $this->receivedAt;
    }

    public function setReceivedAt(\DateTimeInterface $receivedAt): self
    {
        $this->receivedAt = $receivedAt;

        return $this;
    }

    public function getSerial(): ?string
    {
        return $this->serial;
    }

    public function setSerial(string $serial): self
    {
        $this->serial = $serial;

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

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
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

    public function getDonor(): ?Society
    {
        return $this->donor;
    }

    public function setDonor(?Society $donor): self
    {
        $this->donor = $donor;

        return $this;
    }

    public function getMember(): ?MemberShip
    {
        return $this->member;
    }

    public function setMember(?MemberShip $member): self
    {
        $this->member = $member;

        return $this;
    }
}
