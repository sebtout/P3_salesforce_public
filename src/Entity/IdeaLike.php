<?php

namespace App\Entity;

use App\Repository\IdeaLikeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IdeaLikeRepository::class)]
class IdeaLike
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'likes')]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    private ?Idea $idea = null;

    #[ORM\ManyToOne(inversedBy: 'ideaLikes')]
    private ?User $user = null;

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
        $this->idea->addLike($this);

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
        $this->user->addIdeaLike($this);

        return $this;
    }
}
