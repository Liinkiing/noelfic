<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FictionChapterCommentRepository")
 */
class FictionChapterComment extends Comment
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\FictionChapter", inversedBy="comments")
     * @ORM\JoinColumn(nullable=true)
     */
    private $chapter;

    public function getChapter(): ?FictionChapter
    {
        return $this->chapter;
    }

    public function setChapter(?FictionChapter $chapter): self
    {
        $this->chapter = $chapter;

        return $this;
    }

    public function getRelated()
    {
        return $this->chapter;
    }
}
