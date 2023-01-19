<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    private ?Idea $idea = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'Don\'t leave me empty')]
    #[Assert\Length(
        max: 500,
        maxMessage: 'The entered comment is too long, it should not exceed {{ limit }} characters',
    )]
    private ?string $content = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private DateTime $createdAt;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $author = null;

    public function __construct()
    {
        $this->createdAt = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdea(): ?Idea
    {
        return $this->idea;
    }

    public function setIdea(?Idea $idea): self
    {
        $this->idea = $idea;

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

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }
}
