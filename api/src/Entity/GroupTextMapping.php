<?php

namespace App\Entity;

use App\Repository\GroupTextMappingRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: GroupTextMappingRepository::class)]
#[ORM\HasLifecycleCallbacks]
class GroupTextMapping
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'MappingId')]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false, name: 'TextEntryTextId', referencedColumnName: 'TextID')]
    private ?TextEntry $text = null;

    #[Ignore]
    #[ORM\Column(name: 'IsDeleted')]
    private ?bool $deleted = null;

    #[Ignore]
    #[ORM\ManyToOne(inversedBy: 'groupTextMappings')]
    #[ORM\JoinColumn(nullable: false, name: 'SurveyId', referencedColumnName: 'SurveyId')]
    private ?Survey $survey = null;

    #[Assert\Positive]
    #[Assert\LessThanOrEqual(5)]
    #[ORM\Column(nullable: true, name: 'GroupId')]
    private ?int $textGroup = null;

    public function __construct()
    {
        $this->deleted = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?TextEntry
    {
        return $this->text;
    }

    public function setText(?TextEntry $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function isDeleted(): ?bool
    {
        return $this->deleted;
    }

    public function setDeleted(bool $deleted): static
    {
        $this->deleted = $deleted;

        return $this;
    }

    public function getSurvey(): ?Survey
    {
        return $this->survey;
    }

    public function setSurvey(?Survey $survey): static
    {
        $this->survey = $survey;

        return $this;
    }

    public function getTextGroup(): ?int
    {
        return $this->textGroup;
    }

    public function setTextGroup(?int $textGroup): static
    {
        $this->textGroup = $textGroup;

        return $this;
    }
}
