<?php

namespace App\Entity;
use Symfony\Component\Serializer\Annotation\Groups;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $png;

    #[ORM\Column(type: 'string', length: 255)]
    private $webp;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPng(): ?string
    {
        return $this->png;
    }

    public function setPng(string $png): self
    {
        $this->png = $png;

        return $this;
    }

    public function getWebp(): ?string
    {
        return $this->webp;
    }

    public function setWebp(string $webp): self
    {
        $this->webp = $webp;

        return $this;
    }
}
