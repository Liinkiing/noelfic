<?php

namespace App\Entity;

use App\Traits\Timestampable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="comment_type", type="string")
 * @ORM\DiscriminatorMap({
 *      "fiction" = "FictionComment",
 *      "fictionChapter" = "FictionChapterComment"
 * })
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 */
abstract class Comment
{
    use Timestampable;

    public function __construct()
    {
        $this->children = new ArrayCollection();
    }

    /**
     * @ORM\Id()
     * @Groups({"props"})
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     * @ORM\Column(type="uuid")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="comments")
     * @Groups({"props"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @Groups({"props"})
     * @ORM\Column(type="text")
     */
    private $body;

    /**
     * @Groups({"props"})
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="parent", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    protected $children;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Comment", inversedBy="children")
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    protected $parent;

    public function getId(): ?string
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
