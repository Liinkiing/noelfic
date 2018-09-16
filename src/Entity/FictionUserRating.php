<?php

namespace App\Entity;

use App\Utils\Math;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FictionUserRatingRepository")
 */
class FictionUserRating
{

    public const MIN_RATING = 1.0;
    public const MAX_RATING = 10.0;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\Fiction", inversedBy="ratings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fiction;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="fictionRatings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     *
     * @ORM\Column(type="float", precision=1)
     */
    private $rating;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $ratedAt;

    public function __construct(Fiction $fiction, User $user, float $rating)
    {
        $this->fiction = $fiction;
        $this->user = $user;
        $this->rating = Math::clamp($rating, self::MIN_RATING, self::MAX_RATING);
    }

    public function getId(): string
    {
        return $this->fiction->getId() . '-' . $this->user->getId();
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

    public function getRating(): ?float
    {
        return $this->rating;
    }

    public function setRating(int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getRatedAt(): ?\DateTimeInterface
    {
        return $this->ratedAt;
    }

    public function setRatedAt(\DateTimeInterface $ratedAt): self
    {
        $this->ratedAt = $ratedAt;

        return $this;
    }
}
