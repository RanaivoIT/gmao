<?php

namespace App\Entity;

use App\Repository\EquipementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EquipementRepository::class)]
class Equipement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $maker = null;

    #[ORM\Column(length: 255)]
    private ?string $origin = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $picture = null;

    #[ORM\OneToMany(mappedBy: 'equipement', targetEntity: Document::class, orphanRemoval: true)]
    private Collection $documents;

    #[ORM\OneToMany(mappedBy: 'equipement', targetEntity: Organe::class, orphanRemoval: true)]
    private Collection $organes;

    #[ORM\OneToMany(mappedBy: 'equipement', targetEntity: Localisation::class, orphanRemoval: true)]
    private Collection $localisations;

    public function __construct()
    {
        $this->documents = new ArrayCollection();
        $this->organes = new ArrayCollection();
        $this->localisations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getMaker(): ?string
    {
        return $this->maker;
    }

    public function setMaker(string $maker): self
    {
        $this->maker = $maker;

        return $this;
    }

    public function getOrigin(): ?string
    {
        return $this->origin;
    }

    public function setOrigin(string $origin): self
    {
        $this->origin = $origin;

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

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * @return Collection<int, Document>
     */
    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function addDocument(Document $document): self
    {
        if (!$this->documents->contains($document)) {
            $this->documents->add($document);
            $document->setEquipement($this);
        }

        return $this;
    }

    public function removeDocument(Document $document): self
    {
        if ($this->documents->removeElement($document)) {
            // set the owning side to null (unless already changed)
            if ($document->getEquipement() === $this) {
                $document->setEquipement(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Organe>
     */
    public function getOrganes(): Collection
    {
        return $this->organes;
    }

    public function addOrgane(Organe $organe): self
    {
        if (!$this->organes->contains($organe)) {
            $this->organes->add($organe);
            $organe->setEquipement($this);
        }

        return $this;
    }

    public function removeOrgane(Organe $organe): self
    {
        if ($this->organes->removeElement($organe)) {
            // set the owning side to null (unless already changed)
            if ($organe->getEquipement() === $this) {
                $organe->setEquipement(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Localisation>
     */
    public function getLocalisations(): Collection
    {
        return $this->localisations;
    }

    public function addLocalisation(Localisation $localisation): self
    {
        if (!$this->localisations->contains($localisation)) {
            $this->localisations->add($localisation);
            $localisation->setEquipement($this);
        }

        return $this;
    }

    public function removeLocalisation(Localisation $localisation): self
    {
        if ($this->localisations->removeElement($localisation)) {
            // set the owning side to null (unless already changed)
            if ($localisation->getEquipement() === $this) {
                $localisation->setEquipement(null);
            }
        }

        return $this;
    }
}
