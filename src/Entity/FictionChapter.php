<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;


/**
 * @ORM\Entity(repositoryClass="App\Repository\FictionChapterRepository")
 */
class FictionChapter
{
    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     * @ORM\Column(type="uuid")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=191)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=191)
     * @Gedmo\Slug(fields={"title"})
     */
    private $slug;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $body;

    /**
     * @ORM\ManyToOne(targetEntity="Fiction", inversedBy="chapters")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fiction;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="fictionChapters")
     */
    private $authors;

    /**
     * @ORM\Column(type="integer")
     */
    private $position = 1;

    public function __construct()
    {
        $this->authors = new ArrayCollection();
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

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(?string $body): self
    {
        $this->body = $body;

        return $this;
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

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getAuthors(): Collection
    {
        return $this->authors;
    }

    public function addAuthor(User $author): self
    {
        if (!$this->authors->contains($author)) {
            $this->authors[] = $author;
            $author->addFictionChapter($this);
        }

        return $this;
    }

    public function removeAuthor(User $author): self
    {
        if ($this->authors->contains($author)) {
            $this->authors->removeElement($author);
            $author->removeFictionChapter($this);
        }

        return $this;
    }

}
