<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Categorie = null;

    #[ORM\OneToMany(mappedBy: 'Categorie', targetEntity: Haie::class)]
    private Collection $haies;

    public function __construct()
    {
        $this->haies = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategorie(): ?string
    {
        return $this->Categorie;
    }

    public function setCategorie(string $Categorie): self
    {
        $this->Categorie = $Categorie;

        return $this;
    }

    /**
     * @return Collection<int, Haie>
     */
    public function getHaies(): Collection
    {
        return $this->haies;
    }

    public function addHaie(Haie $haie): self
    {
        if (!$this->haies->contains($haie)) {
            $this->haies->add($haie);
            $haie->setCategorie($this);
        }

        return $this;
    }

    public function removeHaie(Haie $haie): self
    {
        if ($this->haies->removeElement($haie)) {
            // set the owning side to null (unless already changed)
            if ($haie->getCategorie() === $this) {
                $haie->setCategorie(null);
            }
        }

        return $this;
    }

}
