<?php

namespace App\Entity;

use App\Repository\DevisRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: DevisRepository::class)]
class Devis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Veuillez entrer votre prénom')]
    #[Assert\Length(
        min:3,
        minMessage: 'Votre prénom doit contenir au minimum 2 caractères',
        max: 30,
        maxMessage: 'Votre prénom est trop long'
    )]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Veuillez entrer votre nom')]
    #[Assert\Length(
                        min:3,
                        minMessage: 'Votre nom doit contenir au minimum 2 caractères',
                        max: 30,
                        maxMessage: 'Votre nom est trop long'
                    )]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    #[Assert\Email(message:'Veuillez saisir un Email valide')]
    #[Assert\NotBlank(message: 'Veuillez renseigner une adresse email')]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Donnez un titre à votre demande')]
    #[Assert\Length(
                        min:8,
                        minMessage: 'Votre titre doit contenir au minimum 8 caractères',
                        max: 30,
                        maxMessage: 'Votre titre est trop long'
                    )]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'Spécifiez votre demande')]
    #[Assert\Length(
                        min:15,
                        minMessage: 'Votre demande doit contenir au minimum 15 caractères',
                        max: 200,
                        maxMessage: 'Votre demande est trop longue'
                    )]
    private ?string $content = null;

    #[ORM\ManyToOne(inversedBy: 'deviss')]
    private ?User $user = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
