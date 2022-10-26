<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TagRepository::class)]
class Tag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $tag = null;

    #[ORM\OneToMany(mappedBy: 'tag', targetEntity: Annonce::class)]
    private Collection $IdAnnonce;

    public function __construct()
    {
        $this->IdAnnonce = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTag(): ?string
    {
        return $this->tag;
    }

    public function setTag(string $tag): self
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * @return Collection<int, Annonce>
     */
    public function getIdAnnonce(): Collection
    {
        return $this->IdAnnonce;
    }

    public function addIdAnnonce(Annonce $idAnnonce): self
    {
        if (!$this->IdAnnonce->contains($idAnnonce)) {
            $this->IdAnnonce->add($idAnnonce);
            $idAnnonce->setTag($this);
        }

        return $this;
    }

    public function removeIdAnnonce(Annonce $idAnnonce): self
    {
        if ($this->IdAnnonce->removeElement($idAnnonce)) {
            // set the owning side to null (unless already changed)
            if ($idAnnonce->getTag() === $this) {
                $idAnnonce->setTag(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->tag;
    }
}
