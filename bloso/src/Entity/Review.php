<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReviewRepository")
 */
class Review
{
    use Timestampable;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Fill your name")
     */
    private $user_name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Camp", inversedBy="reviews")
     * @ORM\JoinColumn(nullable=false)
     */
    private $camp_id;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    private $message;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserName(): ?string
    {
        return $this->user_name;
    }

    public function setUserName(string $user_name): self
    {
        $this->user_name = $user_name;

        return $this;
    }

    public function getCampId(): ?Camp
    {
        return $this->camp_id;
    }

    public function setCampId(?Camp $camp_id): self
    {
        $this->camp_id = $camp_id;

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
