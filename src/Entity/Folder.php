<?php

namespace App\Entity;

use App\Repository\FolderRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FolderRepository::class)]
class Folder
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $urbaPermissionNumber = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $petitionerName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $addressOfWorks = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $detailsOfWorks = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrbaPermissionNumber(): ?string
    {
        return $this->urbaPermissionNumber;
    }

    public function setUrbaPermissionNumber(?string $urbaPermissionNumber): static
    {
        $this->urbaPermissionNumber = $urbaPermissionNumber;

        return $this;
    }

    public function getPetitionerName(): ?string
    {
        return $this->petitionerName;
    }

    public function setPetitionerName(?string $petitionerName): static
    {
        $this->petitionerName = $petitionerName;

        return $this;
    }

    public function getAddressOfWorks(): ?string
    {
        return $this->addressOfWorks;
    }

    public function setAddressOfWorks(?string $addressOfWorks): static
    {
        $this->addressOfWorks = $addressOfWorks;

        return $this;
    }

    public function getDetailsOfWorks(): ?string
    {
        return $this->detailsOfWorks;
    }

    public function setDetailsOfWorks(?string $detailsOfWorks): static
    {
        $this->detailsOfWorks = $detailsOfWorks;

        return $this;
    }
}
