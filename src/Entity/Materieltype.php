<?php

namespace App\Entity;

use App\Repository\MaterieltypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MaterieltypeRepository::class)
 */
class Materieltype
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $marque;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $modele;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $categorie;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $document;

    /**
     * @ORM\OneToMany(targetEntity=Materiel::class, mappedBy="materieltype")
     */
    private $materiels;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo_titre;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $photo_description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $document_titre;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $document_description;

    public function __construct()
    {
        $this->materiels = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    public function getModele(): ?string
    {
        return $this->modele;
    }

    public function setModele(string $modele): self
    {
        $this->modele = $modele;

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getDocument(): ?string
    {
        return $this->document;
    }

    public function setDocument(?string $document): self
    {
        $this->document = $document;

        return $this;
    }

    /**
     * @return Collection|Materiel[]
     */
    public function getMateriels(): Collection
    {
        return $this->materiels;
    }

    public function addMateriel(Materiel $materiel): self
    {
        if (!$this->materiels->contains($materiel)) {
            $this->materiels[] = $materiel;
            $materiel->setMaterieltype($this);
        }

        return $this;
    }

    public function removeMateriel(Materiel $materiel): self
    {
        if ($this->materiels->removeElement($materiel)) {
            // set the owning side to null (unless already changed)
            if ($materiel->getMaterieltype() === $this) {
                $materiel->setMaterieltype(null);
            }
        }

        return $this;
    }

    public function getPhotoTitre(): ?string
    {
        return $this->photo_titre;
    }

    public function setPhotoTitre(string $photo_titre): self
    {
        $this->photo_titre = $photo_titre;

        return $this;
    }

    public function getPhotoDescription(): ?string
    {
        return $this->photo_description;
    }

    public function setPhotoDescription(?string $photo_description): self
    {
        $this->photo_description = $photo_description;

        return $this;
    }

    public function getDocumentTitre(): ?string
    {
        return $this->document_titre;
    }

    public function setDocumentTitre(?string $document_titre): self
    {
        $this->document_titre = $document_titre;

        return $this;
    }

    public function getDocumentDescription(): ?string
    {
        return $this->document_description;
    }

    public function setDocumentDescription(?string $document_description): self
    {
        $this->document_description = $document_description;

        return $this;
    }
}
