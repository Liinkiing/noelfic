<?php

namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Ramsey\Uuid\Uuid;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\EntityListeners({"App\EventListener\UserListener"})
 * @UniqueEntity("email")
 * @UniqueEntity("username")
 */
class User implements UserInterface, \Serializable
{
    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @Groups({"props"})
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     * @ORM\Column(type="uuid")
     */
    private $id;

    /**
     * @Groups({"props"})
     * @Assert\Length(min="3", max="30")
     * @ORM\Column(type="string", length=30, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $password;

    /**
     * @Assert\Email()
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\FictionChapter", inversedBy="authors")
     */
    private $fictionChapters;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\UserRole", inversedBy="users")
     */
    private $roles;

    /**
     * @ORM\Column(type="string", length=90, nullable=true)
     */
    private $confirmationToken;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $confirmedAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $plainPassword;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FictionUserRating", mappedBy="user", orphanRemoval=true)
     */
    private $fictionRatings;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FictionUserFavorite", mappedBy="user", orphanRemoval=true)
     */
    private $fictionFavorites;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="author", orphanRemoval=true)
     */
    private $comments;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $confirmationExpiresAt;

    public function __construct()
    {
        $this->fictionChapters = new ArrayCollection();
        $this->roles = new ArrayCollection();
        $this->fictionRatings = new ArrayCollection();
        $this->fictionFavorites = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return Collection|FictionChapter[]
     */
    public function getFictionChapters(): Collection
    {
        return $this->fictionChapters;
    }

    public function addFictionChapter(FictionChapter $fiction): self
    {
        if (!$this->fictionChapters->contains($fiction)) {
            $this->fictionChapters[] = $fiction;
        }

        return $this;
    }

    public function removeFictionChapter(FictionChapter $fiction): self
    {
        if ($this->fictionChapters->contains($fiction)) {
            $this->fictionChapters->removeElement($fiction);
        }

        return $this;
    }

    public function serialize(): string
    {
        return \serialize([
            $this->id,
            $this->username,
            $this->password
        ]);
    }

    public function unserialize($serialized): void
    {
        [
            $this->id,
            $this->username,
            $this->password,
        ] = unserialize($serialized, [Uuid::class]);
    }


    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials(): void
    {
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles->map(function (UserRole $role) {
                return $role->getRole();
            })->toArray();
    }

    /**
     * @return Collection|UserRole[]
     */
    public function getRealRoles(): ?Collection
    {
        return $this->roles;
    }

    public function addRole(UserRole $role): self
    {
        if (!$this->roles->contains($role)) {
            $this->roles[] = $role;
        }

        return $this;
    }

    public function removeRole(UserRole $role): self
    {
        if ($this->roles->contains($role)) {
            $this->roles->removeElement($role);
        }

        return $this;
    }

    public function getConfirmationToken(): ?string
    {
        return $this->confirmationToken;
    }

    public function setConfirmationToken(?string $confirmationToken): self
    {
        $this->confirmationToken = $confirmationToken;
        $this->confirmationExpiresAt = (new \DateTime())->add(new \DateInterval('P2D'));

        return $this;
    }

    public function clearConfirmationToken(): self
    {
        $this->confirmationToken = null;
        $this->confirmationExpiresAt = null;

        return $this;
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

    public function getConfirmedAt(): ?\DateTimeInterface
    {
        return $this->confirmedAt;
    }

    public function isConfirmed(): bool
    {
        return $this->confirmedAt !== null;
    }

    public function canConfirm(): bool
    {
        return new \DateTime() < $this->confirmationExpiresAt;
    }

    public function setConfirmedAt(?\DateTimeInterface $confirmedAt): self
    {
        $this->confirmedAt = $confirmedAt;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @return Collection|FictionUserRating[]
     */
    public function getFictionRatings(): Collection
    {
        return $this->fictionRatings;
    }

    public function addFictionRating(FictionUserRating $fictionRating): self
    {
        if (!$this->fictionRatings->contains($fictionRating)) {
            $this->fictionRatings[] = $fictionRating;
            $fictionRating->setUser($this);
        }

        return $this;
    }

    public function removeFictionRating(FictionUserRating $fictionRating): self
    {
        if ($this->fictionRatings->contains($fictionRating)) {
            $this->fictionRatings->removeElement($fictionRating);
            // set the owning side to null (unless already changed)
            if ($fictionRating->getUser() === $this) {
                $fictionRating->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|FictionUserFavorite[]
     */
    public function getFictionFavorites(): Collection
    {
        return $this->fictionFavorites;
    }

    public function addFavorite(FictionUserFavorite $favorite): self
    {
        if (!$this->fictionFavorites->contains($favorite)) {
            $this->fictionFavorites[] = $favorite;
            $favorite->setUser($this);
        }

        return $this;
    }

    public function removeFavorite(FictionUserFavorite $favorite): self
    {
        if ($this->fictionFavorites->contains($favorite)) {
            $this->fictionFavorites->removeElement($favorite);
            // set the owning side to null (unless already changed)
            if ($favorite->getUser() === $this) {
                $favorite->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function getConfirmationExpiresAt(): ?\DateTimeInterface
    {
        return $this->confirmationExpiresAt;
    }

    public function setConfirmationExpiresAt(?\DateTimeInterface $confirmationExpiresAt): self
    {
        $this->confirmationExpiresAt = $confirmationExpiresAt;

        return $this;
    }

}
