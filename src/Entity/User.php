<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Serializable;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use DateTime;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[Vich\Uploadable]
class User implements UserInterface, PasswordAuthenticatedUserInterface, Serializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]

    #[Assert\NotBlank(message: 'Don\'t leave me empty')]
    #[Assert\Email(message: 'The email is not valid')]

    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Assert\NotBlank(message: 'Don\'t leave me empty')]
    #[Assert\Length(
        min: 6,
        minMessage: 'The password entered is too short, it should exceed {{ limit }} characters',
    )]

    private ?string $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message: 'Don\'t leave me empty')]
    #[Assert\Length(
        max: 255,
        maxMessage: 'The lastname entered is too long, it should not exceed {{ limit }} characters',
    )]
    private ?string $lastname = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message: 'Don\'t leave me empty')]
    #[Assert\Length(
        max: 255,
        maxMessage: 'The firstname entered is too long, it should not exceed {{ limit }} characters',
    )]
    private ?string $firstname = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message: 'Don\'t leave me empty')]
    #[Assert\Length(
        max: 255,
        maxMessage: 'The profession entered is too long, it should not exceed {{ limit }} characters',
    )]
    private ?string $profession = null;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Idea::class, orphanRemoval: true)]
    private Collection $ideas;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Comment::class, orphanRemoval: true)]
    private Collection $comments;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: IdeaLike::class)]
    private Collection $ideaLikes;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $profilePicture;

    #[Vich\UploadableField(mapping: 'profile_file', fileNameProperty: 'profilePicture')]
    #[Assert\File(
        maxSize: '1M',
        mimeTypes: ['image/jpeg', 'image/png'],
    )]

    private ?File $profilePictureFile = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DateTime $updateAt = null;

    #[ORM\Column]
    private ?bool $isActive = null;

    public function __construct()
    {
        $this->ideas = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->ideaLikes = new ArrayCollection();
        $this->isActive = true;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): string
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
        return '0';
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getProfession(): ?string
    {
        return $this->profession;
    }

    public function setProfession(?string $profession): self
    {
        $this->profession = $profession;

        return $this;
    }

    /**
     * @return Collection<int, Idea>
     */
    public function getIdeas(): Collection
    {
        return $this->ideas;
    }

    public function addIdea(Idea $idea): self
    {
        if (!$this->ideas->contains($idea)) {
            $this->ideas->add($idea);
            $idea->setAuthor($this);
        }

        return $this;
    }

    public function removeIdea(Idea $idea): self
    {
        if ($this->ideas->removeElement($idea)) {
            // set the owning side to null (unless already changed)
            if ($idea->getAuthor() === $this) {
                $idea->setAuthor(null);
            }
        }

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
            $comment->setAuthor($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getAuthor() === $this) {
                $comment->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, IdeaLike>
     */
    public function getIdeaLikes(): Collection
    {
        return $this->ideaLikes;
    }

    public function addIdeaLike(IdeaLike $ideaLike): self
    {
        if (!$this->ideaLikes->contains($ideaLike)) {
            $this->ideaLikes->add($ideaLike);
            $ideaLike->setUser($this);
        }

        return $this;
    }

    public function removeIdeaLike(IdeaLike $ideaLike): self
    {
        if ($this->ideaLikes->removeElement($ideaLike)) {
            // set the owning side to null (unless already changed)
            if ($ideaLike->getUser() === $this) {
                $ideaLike->setUser(null);
            }
        }

        return $this;
    }

    public function getProfilePicture(): ?string
    {
        return $this->profilePicture;
    }

    /**
     * Set the value of profilePicture
     *
     * @return  self
     */
    public function setProfilePicture(string $profilePicture)
    {
        $this->profilePicture = $profilePicture;

        return $this;
    }

    public function setprofilePictureFile(File $image = null): User
    {
        $this->profilePictureFile = $image;
        if ($image) {
            $this->updateAt = new DateTime('now');
        }
        return $this;
    }

    public function getprofilePictureFile(): ?File
    {
        return $this->profilePictureFile;
    }

    public function getUpdateAt(): ?DateTime
    {
        return $this->updateAt;
    }

    public function setUpdateAt(?DateTime $updateAt): self
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    public function serialize()
    {
        return serialize([
            'id' => $this->getId(),
            'password' => $this->getPassword(),
            'email' => $this->getEmail(),
            'userLastname' => $this->getLastname(),
            'userFirstname' => $this->getFirstname(),
            'roles' => $this->getRoles(),
            'isActive' => $this->isIsActive(),
        ]);
    }

    public function unserialize($data)
    {
        $unserialized = unserialize($data);

        $this
            ->setId($unserialized['id'])
            ->setPassword($unserialized['password'])
            ->setEmail($unserialized['email'])
            ->setLastname($unserialized['userLastname'])
            ->setFirstname($unserialized['userFirstname'])
            ->setRoles($unserialized['roles'])
            ->setIsActive($unserialized['isActive']);
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    public function __toString()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function isIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }
}
