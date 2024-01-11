<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\HasLifecycleCallbacks]
class User
{
    #[Assert\Email]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    #[ORM\Id]
    #[ORM\Column(length: 255, name: 'Email')]
    private ?string $email = null;

    #[Assert\PositiveOrZero]
    #[Assert\LessThanOrEqual(5)]
    #[ORM\Column(type: Types::SMALLINT, nullable: true, name: 'EnglishLevel')]
    private ?int $englishLevel = null;

    #[Assert\Language]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    #[ORM\Column(length: 255, name: 'NativeLanguage')]
    private ?string $nativeLanguage = null;

    #[Assert\PositiveOrZero]
    #[Assert\LessThanOrEqual(2)]
    #[ORM\Column(type: Types::SMALLINT, nullable: true, name: 'Gender')]
    private ?int $gender = null;

    #[Assert\NotBlank(allowNull: true)]
    #[Assert\Length(max: 255)]
    #[ORM\Column(length: 255, nullable: true, name: 'Education')]
    private ?string $education = null;

    #[Assert\Country]
    #[Assert\NotBlank(allowNull: true)]
    #[Assert\Length(max: 255)]
    #[ORM\Column(length: 255, nullable: true, name: "Country")]
    private ?string $country = null;

    #[ORM\Column(nullable: true, name: 'IsInterestedInMore')]
    private ?bool $interestedInMoreInfo = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Survey::class, orphanRemoval: true)]
    private Collection $surveys;

    public function __construct($email)
    {
        $this->email = $email;
        $this->surveys = new ArrayCollection();
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getEnglishLevel(): ?int
    {
        return $this->englishLevel;
    }

    public function setEnglishLevel(?int $englishLevel): static
    {
        $this->englishLevel = $englishLevel;

        return $this;
    }

    public function getNativeLanguage(): ?string
    {
        return $this->nativeLanguage;
    }

    public function setNativeLanguage(string $nativeLanguage): static
    {
        $this->nativeLanguage = $nativeLanguage;

        return $this;
    }

    public function getGender(): ?int
    {
        return $this->gender;
    }

    public function setGender(?int $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function getEducation(): ?string
    {
        return $this->education;
    }

    public function setEducation(?string $education): static
    {
        $this->education = $education;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function isInterestedInMoreInfo(): ?bool
    {
        return $this->interestedInMoreInfo;
    }

    public function setInterestedInMoreInfo(?bool $interestedInMoreInfo): static
    {
        $this->interestedInMoreInfo = $interestedInMoreInfo;

        return $this;
    }

    /**
     * @return Collection<int, Survey>
     */
    public function getSurveys(): Collection
    {
        return $this->surveys;
    }

    public function addSurvey(Survey $survey): static
    {
        if (!$this->surveys->contains($survey)) {
            $this->surveys->add($survey);
            $survey->setUser($this);
        }

        return $this;
    }

    public function removeSurvey(Survey $survey): static
    {
        if ($this->surveys->removeElement($survey)) {
            // set the owning side to null (unless already changed)
            if ($survey->getUser() === $this) {
                $survey->setUser(null);
            }
        }

        return $this;
    }
}
