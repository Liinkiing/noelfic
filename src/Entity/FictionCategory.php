<?php

namespace App\Entity;

use App\Traits\Timestampable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FictionCategoryRepository")
 */
class FictionCategory
{
    use Timestampable;

    /**
     * @ORM\Id()
     * @Groups({"props"})
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     * @ORM\Column(type="uuid")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Fiction", inversedBy="categories")
     */
    private $fictions;

    /**
     * @Groups({"props"})
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @Groups({"props"})
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    public function __construct()
    {
        $this->fictions = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @return Collection|Fiction[]
     */
    public function getFictions(): Collection
    {
        return $this->fictions;
    }

    public function addFiction(Fiction $fiction): self
    {
        if (!$this->fictions->contains($fiction)) {
            $this->fictions[] = $fiction;
        }

        return $this;
    }

    public function removeFiction(Fiction $fiction): self
    {
        if ($this->fictions->contains($fiction)) {
            $this->fictions->removeElement($fiction);
        }

        return $this;
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
}
