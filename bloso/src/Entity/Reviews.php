<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReviewsRepository")
 */
class Reviews
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Camps", inversedBy="reviews")
     * @ORM\JoinColumn(nullable=false)
     */
    private $camp_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $reviewer_name;

    /**
     * @ORM\Column(type="text")
     */
    private $message;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCampId(): ?camps
    {
        return $this->camp_id;
    }

    public function setCampId(?camps $camp_id): self
    {
        $this->camp_id = $camp_id;

        return $this;
    }

    public function getReviewerName(): ?string
    {
        return $this->reviewer_name;
    }

    public function setReviewerName(string $reviewer_name): self
    {
        $this->reviewer_name = $reviewer_name;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }
}
