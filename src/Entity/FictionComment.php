<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FictionCommentRepository")
 */
class FictionComment extends Comment
{

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Fiction", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fiction;

    public function getFiction(): ?Fiction
    {
        return $this->fiction;
    }

    public function setFiction(?Fiction $fiction): self
    {
        $this->fiction = $fiction;

        return $this;
    }

    public function getRelated(): Fiction
    {
        return $this->fiction;
    }
}
