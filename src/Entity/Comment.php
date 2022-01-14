<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $content;

    #[ORM\Column(type: 'datetime_immutable')]
    private $createdAt;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $parentID;

    #[ORM\Column(type: 'integer')]
    private $score;

    #[ORM\ManyToOne(targetEntity: Commenter::class, inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private $commenter;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getParentID(): ?int
    {
        return $this->parentID;
    }

    public function setParentID(?int $parentID): self
    {
        $this->parentID = $parentID;

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getCommenter(): ?Commenter
    {
        return $this->commenter;
    }

    public function setCommenter(?Commenter $commenter): self
    {
        $this->commenter = $commenter;

        return $this;
    }
}
