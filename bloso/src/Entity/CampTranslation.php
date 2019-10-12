<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Translatable\Translation;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CampTranslationRepository")
 */
class CampTranslation
{
    use Translation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $quote;

    /**
     * @ORM\Column(type="text")
     */
    private $description;


    public function getQuote(): ?string
    {
        return $this->quote;
    }

    public function setQuote(string $quote): self
    {
        $this->quote = $quote;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
