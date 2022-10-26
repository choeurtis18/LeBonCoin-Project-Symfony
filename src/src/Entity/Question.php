<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $question = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Annonce $IdAnnonce = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $IdUser = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Answer $IdAnswer = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getIdAnnonce(): ?Annonce
    {
        return $this->IdAnnonce;
    }

    public function setIdAnnonce(?Annonce $IdAnnonce): self
    {
        $this->IdAnnonce = $IdAnnonce;

        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->IdUser;
    }

    public function setIdUser(?User $IdUser): self
    {
        $this->IdUser = $IdUser;

        return $this;
    }

    public function getIdAnswer(): ?Answer
    {
        return $this->IdAnswer;
    }

    public function setIdAnswer(?Answer $IdAnswer): self
    {
        $this->IdAnswer = $IdAnswer;

        return $this;
    }

    public function hydrate(array $donnees)
    {
        foreach($donnees as $cle =>$valeur) {
            $method='set'.ucfirst($cle);
            if(method_exists($this,$method)) {
                return $this->$method($valeur);
            }
        }
    }
}
