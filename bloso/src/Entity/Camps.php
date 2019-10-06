<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CampsRepository")
 */
class Camps
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $author;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_time;

    /**
     * @ORM\Column(type="integer")
     */
    private $likes;

    /**
     * @ORM\Column(type="text")
     */
    private $paragraphs;

    /**
     * @ORM\Column(type="text")
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $quote;

    /**
     * @ORM\Column(type="boolean")
     */
    private $in_preview;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reviews", mappedBy="camp_id", orphanRemoval=true)
     */
    private $reviews;

    public function __construct()
    {
        $this->reviews = new ArrayCollection();
        $this->created_time = new \DateTime();
    }

    public function getId(): ?int
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

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getCreatedTime(): ?\DateTimeInterface
    {
        return $this->created_time;
    }

    public function setCreatedTime(\DateTimeInterface $created_time): self
    {
        $this->created_time = $created_time;

        return $this;
    }

    public function getLikes(): ?int
    {
        return $this->likes;
    }

    public function setLikes(int $likes): self
    {
        $this->likes = $likes;

        return $this;
    }

    public function getParagraphs(): ?string
    {
        return $this->paragraphs;
    }

    public function setParagraphs(string $paragraphs): self
    {
        $this->paragraphs = $paragraphs;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getQuote(): ?string
    {
        return $this->quote;
    }

    public function setQuote(string $quote): self
    {
        $this->quote = $quote;

        return $this;
    }

    public function getInPreview(): ?bool
    {
        return $this->in_preview;
    }

    public function setInPreview(bool $in_preview): self
    {
        $this->in_preview = $in_preview;

        return $this;
    }

    /**
     * @return Collection|Reviews[]
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Reviews $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews[] = $review;
            $review->setCampId($this);
        }
        return $this;
    }

    public function removeReview(Reviews $review): self
    {
        if ($this->reviews->contains($review)) {
            $this->reviews->removeElement($review);
            // set the owning side to null (unless already changed)
            if ($review->getCampId() === $this) {
                $review->setCampId(null);
            }
        }

        return $this;
    }
}
