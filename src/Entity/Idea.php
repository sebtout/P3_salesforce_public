<?php

namespace App\Entity;

use App\Repository\IdeaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: IdeaRepository::class)]
#[UniqueEntity(
    fields:['title'],
    errorPath: '',
    message:'Don\'t leave me empty'
)]

class Idea
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name:'title', type: 'string', length: 255, unique: true)]
    #[Assert\NotBlank(message: 'Don\'t leave me empty')]
    #[Assert\Length(
        max: 255,
        maxMessage: 'The category entered is too long, it should not exceed  characters {{ limit }} characters',
    )]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'Don\'t leave me empty')]
    #[Assert\Length(
        max: 500,
        maxMessage: 'The category entered is too long, it should not exceed  characters {{ limit }} characters',
    )]
    private ?string $content = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Don\'t leave me empty')]
    #[Assert\Length(
        max: 255,
        maxMessage: 'The category entered is too long, it should not exceed  characters {{ limit }} characters',
    )]
    private ?string $status = null;

    #[ORM\OneToMany(mappedBy: 'idea', targetEntity: Comment::class, orphanRemoval: true)]
    private Collection $comments;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setIdea($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getIdea() === $this) {
                $comment->setIdea(null);
            }
        }

        return $this;
    }
}
