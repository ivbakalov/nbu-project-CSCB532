<?php

namespace App\Entity;

use App\Repository\SurveyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: SurveyRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Survey
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'SurveyId')]
    private ?int $id = null;

    #[Ignore]
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false, name: 'VariantId', referencedColumnName: 'VariantId')]
    private ?Variant $variant = null;

    #[Ignore]
    #[ORM\ManyToOne(inversedBy: 'surveys')]
    #[ORM\JoinColumn(name: 'UserEmail', referencedColumnName: 'Email', nullable: false)]
    private ?User $user = null;

    #[ORM\Column(name: 'IsCompleted')]
    private ?bool $completed = null;

    #[Ignore]
    #[ORM\Column(name: 'CreatedDate')]
    private ?\DateTimeImmutable $createdDate = null;

    #[Ignore]
    #[ORM\Column(name: 'FinishedOnDate', nullable: true)]
    private ?\DateTimeImmutable $finishedOnDate = null;

    #[ORM\OneToMany(mappedBy: 'survey', targetEntity: GroupTextMapping::class, orphanRemoval: true)]
    private Collection $groupTextMappings;

    public function __construct()
    {
        $this->completed = false;
        $this->groupTextMappings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVariant(): ?Variant
    {
        return $this->variant;
    }

    public function setVariant(?Variant $variant): static
    {
        $this->variant = $variant;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getCreatedDate(): ?\DateTimeImmutable
    {
        return $this->createdDate;
    }

    #[ORM\PrePersist]
    public function setCreatedDate(): static
    {
        $this->createdDate = new DateTimeImmutable('now');

        return $this;
    }

    /**
     * @return Collection<int, GroupTextMapping>
     */
    public function getGroupTextMappings(): Collection
    {
        return $this->groupTextMappings;
    }

    public function addGroupTextMapping(GroupTextMapping $groupTextMapping): static
    {
        if (!$this->groupTextMappings->contains($groupTextMapping)) {
            $this->groupTextMappings->add($groupTextMapping);
            $groupTextMapping->setSurvey($this);
        }

        return $this;
    }

    public function removeGroupTextMapping(GroupTextMapping $groupTextMapping): static
    {
        if ($this->groupTextMappings->removeElement($groupTextMapping)) {
            // set the owning side to null (unless already changed)
            if ($groupTextMapping->getSurvey() === $this) {
                $groupTextMapping->setSurvey(null);
            }
        }

        return $this;
    }

    public function isCompleted(): ?bool
    {
        return $this->completed;
    }

    public function setCompleted(bool $completed): static
    {
        $this->completed = $completed;

        return $this;
    }

    public function getFinishedOnDate(): ?\DateTimeImmutable
    {
        return $this->finishedOnDate;
    }

    public function setFinishedOnDate(\DateTimeImmutable $finishedOnDate): static
    {
        $this->finishedOnDate = $finishedOnDate;

        return $this;
    }
}
