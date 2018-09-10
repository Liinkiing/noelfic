<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use function iter\reduce;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FictionRepository")
 */
class Fiction
{
    public const NUM_ITEMS = 5;

    use TimestampableEntity;

    /**
     * @Groups({"props"})
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     * @ORM\Column(type="uuid")
     */
    private $id;

    /**
     * @Groups({"props"})
     * @ORM\Column(type="string", length=191)
     */
    private $title;

    /**
     * @Groups({"props"})
     * @ORM\Column(type="string", length=191)
     * @Gedmo\Slug(fields={"title"})
     */
    private $slug;

    /**
     * @Groups({"props"})
     * @ORM\OneToMany(targetEntity="FictionChapter", mappedBy="fiction", orphanRemoval=true, cascade={"persist"}, fetch="LAZY")
     * @ORM\OrderBy({"position": "ASC"})
     */
    private $chapters;

    /**
     * @Groups({"props"})
     * @ORM\OneToMany(targetEntity="App\Entity\FictionUserRating", mappedBy="fiction", orphanRemoval=true, fetch="LAZY")
     */
    private $ratings;

    /**
     * @Groups({"props"})
     * @ORM\OneToMany(targetEntity="App\Entity\FictionComment", mappedBy="fiction", orphanRemoval=true, fetch="LAZY")
     */
    private $comments;


    public function __construct()
    {
        $this->chapters = new ArrayCollection();
        $this->ratings = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function getId()
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection|FictionChapter[]
     */
    public function getChapters(): Collection
    {
        return $this->chapters;
    }

    public function getChapter(int $position): ?FictionChapter
    {
        $results = $this->chapters->filter(function (FictionChapter $chapter) use ($position) {
            return $chapter->getPosition() === $position;
        });
        return $results->count() > 0 ? $results->first() : null;
    }

    public function addChapter(FictionChapter $chapter): self
    {
        if (!$this->chapters->contains($chapter)) {
            $this->chapters[] = $chapter;
            $chapter->setFiction($this);
        }

        return $this;
    }

    public function removeChapter(FictionChapter $chapter): self
    {
        if ($this->chapters->contains($chapter)) {
            $this->chapters->removeElement($chapter);
            // set the owning side to null (unless already changed)
            if ($chapter->getFiction() === $this) {
                $chapter->setFiction(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|FictionUserRating[]
     */
    public function getRatings(): Collection
    {
        return $this->ratings;
    }

    /**
     * @Groups({"props"})
     */
    public function getAverageRating(int $precision = 1): ?float
    {
        if ($this->ratings->count() === 0) {
            return null;
        }

        $total = reduce(function (float $acc, FictionUserRating $rating) {
            return $acc + $rating->getRating();
        }, $this->ratings, 0);

        return round($total / $this->ratings->count(), $precision);
    }

    public function addRating(FictionUserRating $rating): self
    {
        if (!$this->ratings->contains($rating)) {
            $this->ratings[] = $rating;
            $rating->setFiction($this);
        }

        return $this;
    }

    public function removeRating(FictionUserRating $rating): self
    {
        if ($this->ratings->contains($rating)) {
            $this->ratings->removeElement($rating);
            // set the owning side to null (unless already changed)
            if ($rating->getFiction() === $this) {
                $rating->setFiction(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|FictionComment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    /**
     * @return Collection|FictionComment[]
     */
    public function getRootComments(): Collection
    {
        return $this->comments->filter(function (FictionComment $comment) {
            return $comment->getParent() === null;
        });
    }

    public function addComment(FictionComment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setFiction($this);
        }

        return $this;
    }

    public function removeComment(FictionComment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getFiction() === $this) {
                $comment->setFiction(null);
            }
        }

        return $this;
    }

    /**
     * @Groups({"props"})
     * @return Collection|User[]
     */
    public function getAuthors(): Collection
    {
        return reduce(function (ArrayCollection $acc, FictionChapter $chapter) {
            foreach ($chapter->getAuthors() as $author) {
                if (!$acc->contains($author)) {
                    $acc->add($author);
                }
            }
            return $acc;
        }, $this->chapters, new ArrayCollection([]));
    }
}
