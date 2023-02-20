<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Validation;

#[UniqueEntity('email')]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\EntityListeners(['App\EntityListener\UserListener'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{


    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.',
    )]
    #[Assert\Length(min: 2 , max: 180)]
    private ?string $email = null;

    #[ORM\Column]
    #[Assert\NotNull]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[Assert\Regex(
        pattern:"/^.{8,}$/",
        message: 'votre mots de passe doit faire au moins 8 charactere',
        match: true
    )]
    #[Assert\Regex(
        pattern:"/(?=.*?[A-Z])/",
        message: 'votre mots de passe doit au moins contenir une majuscule',
        match: true
    )]
    #[Assert\Regex(
        pattern:"/(?=.*?[a-z])/",
        message: 'votre mots de passe doit au moins contenir une minuscule',
        match: true
    )]
    #[Assert\Regex(
        pattern:"/(?=.*?[0-9])/",
        message: 'votre mots de passe doit au moins contenir un chiffre',
        match: true
    )]
    #[Assert\Regex(
        pattern:"/(?=.*?[#?!@$%^&*-])/",
        message: 'votre mots de passe doit au moins contenir un charactére special',
        match: true
    )]
    private ?string $plainPassword = null;

    #[Assert\EqualTo(propertyPath: "plainPassword",message: "la confirmation de mots de passe n'est pas identique")]
    private ?string $ConfirmPassword = null;

    /**
     * @return string|null
     */
    public function getConfirmPassword(): ?string
    {
        return $this->ConfirmPassword;
    }

    /**
     * @param string|null $ConfirmPassword
     */
    public function setConfirmPassword(?string $ConfirmPassword): void
    {
        $this->ConfirmPassword = $ConfirmPassword;
    }

    #[ORM\Column(length: 50)]
    #[Assert\Length(min: 4,max: 50)]
    private ?string $userName = null;

    /**
     * @return string|null
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * @param string|null $plainPassword
     */
    public function setPlainPassword(?string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;

    }



    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUserName(): ?string
    {
        return $this->userName;
    }

    public function setUserName(string $userName): self
    {
        $this->userName = $userName;

        return $this;
    }
}
