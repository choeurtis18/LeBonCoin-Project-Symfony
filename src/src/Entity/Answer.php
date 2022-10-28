<?php

namespace App\Entity;

use App\Repository\AnswerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnswerRepository::class)]
class Answer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $answer = null;

    #[ORM\OneToOne(cascade:["persist"])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Question $IdQuestion = null;

    #[ORM\ManyToOne(cascade:["persist"])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $IdUser = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    public function setAnswer(string $answer): self
    {
        $this->answer = $answer;

        return $this;
    }

    public function getIdQuestion(): ?Question
    {
        return $this->IdQuestion;
    }

    public function setIdQuestion(?Question $IdQuestion): self
    {
        $this->IdQuestion = $IdQuestion;

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
}
