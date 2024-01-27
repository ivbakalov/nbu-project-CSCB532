<?php

namespace App\Entity;

use App\Repository\VariantRepository;
use App\Repository\TextEntryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VariantRepository::class)]
class Variant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'VariantId')]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false, name: 'Text1Id', referencedColumnName: 'TextID')]
    private ?TextEntry $text1 = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false, name: 'Text2Id', referencedColumnName: 'TextID')]
    private ?TextEntry $text2 = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false, name: 'Text3Id', referencedColumnName: 'TextID')]
    private ?TextEntry $text3 = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false, name: 'Text4Id', referencedColumnName: 'TextID')]
    private ?TextEntry $text4 = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false, name: 'Text5Id', referencedColumnName: 'TextID')]
    private ?TextEntry $text5 = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false, name: 'Text6Id', referencedColumnName: 'TextID')]
    private ?TextEntry $text6 = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false, name: 'Text7Id', referencedColumnName: 'TextID')]
    private ?TextEntry $text7 = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false, name: 'Text8Id', referencedColumnName: 'TextID')]
    private ?TextEntry $text8 = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText1(): ?TextEntry
    {
        return $this->text1;
    }

    public function setText1(?TextEntry $text1): static
    {
        $this->text1 = $text1;

        return $this;
    }

    public function getText2(): ?TextEntry
    {
        return $this->text2;
    }

    public function setText2(?TextEntry $text2): static
    {
        $this->text2 = $text2;

        return $this;
    }

    public function getText3(): ?TextEntry
    {
        return $this->text3;
    }

    public function setText3(?TextEntry $text3): static
    {
        $this->text3 = $text3;

        return $this;
    }

    public function getText4(): ?TextEntry
    {
        return $this->text4;
    }

    public function setText4(?TextEntry $text4): static
    {
        $this->text4 = $text4;

        return $this;
    }

    public function getText5(): ?TextEntry
    {
        return $this->text5;
    }

    public function setText5(?TextEntry $text5): static
    {
        $this->text5 = $text5;

        return $this;
    }

    public function getText6(): ?TextEntry
    {
        return $this->text6;
    }

    public function setText6(?TextEntry $text6): static
    {
        $this->text6 = $text6;

        return $this;
    }

    public function getText7(): ?TextEntry
    {
        return $this->text7;
    }

    public function setText7(?TextEntry $text7): static
    {
        $this->text7 = $text7;

        return $this;
    }

    public function getText8(): ?TextEntry
    {
        return $this->text8;
    }

    public function setText8(?TextEntry $text8): static
    {
        $this->text8 = $text8;

        return $this;
    }
}
