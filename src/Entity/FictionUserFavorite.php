<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FictionUserFavoriteRepository")
 */
class FictionUserFavorite
{

    /**
     * @Groups({"props"})
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\Fiction", inversedBy="favorites")
     * @ORM\JoinColumn(name="fiction_id", referencedColumnName="id", nullable=false)
     */
    private $fiction;

    /**
     * @Groups({"props"})
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="fictionFavorites")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;

    public function getId(): string
    {
        return $this->fiction->getId() . '-' . $this->user->getId();
    }

    /**
     * @Groups({"props"})
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $favoritedAt;

    public function __construct(Fiction $fiction, User $user)
    {
        $this->fiction = $fiction;
        $this->user = $user;
    }

    public function getFiction(): ?Fiction
    {
        return $this->fiction;
    }

    public function setFiction(?Fiction $fiction): self
    {
        $this->fiction = $fiction;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getFavoritedAt(): ?\DateTimeInterface
    {
        return $this->favoritedAt;
    }

    public function setFavoritedAt(\DateTimeInterface $favoritedAt): self
    {
        $this->favoritedAt = $favoritedAt;

        return $this;
    }
}
