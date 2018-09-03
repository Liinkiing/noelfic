<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="comment_type", type="string")
 * @ORM\DiscriminatorMap({
 *      "fiction" = "FictionComment"
 * })
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 */
abstract class Comment
{
    use TimestampableEntity;

    public function __construct()
    {
        $this->children = new ArrayCollection();
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     * @ORM\Column(type="uuid")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\Column(type="text")
     */
    private $body;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FictionComment", mappedBy="parent")
     */
    protected $children;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\FictionComment", inversedBy="children")
     */
    protected $parent;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    abstract public function getRelated();

    public function getKind(): string
    {
        return __CLASS__;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(Comment $child): self
    {
        if (!$this->children->contains($child)) {
            $this->children[] = $child;
            $child->setParent($this);
        }

        return $this;
    }


    public function removeChild(Comment $child): self
    {
        if ($this->children->contains($child)) {
            $this->children->removeElement($child);
            if ($child->getParent() === $this) {
                $child->setParent(null);
            }
        }

        return $this;
    }

    public function setParent(Comment $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

}
