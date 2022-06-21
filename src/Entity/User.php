<?php
/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity;

use App\Entity\Enum\UserRole;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * User class.
 */
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(
    fields: ['email'],
    message: 'email.used',
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * Primary key.
     *
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    /**
     * Email.
     *
     * @var string|null
     */
    #[Assert\NotBlank]
    #[Assert\Email]
    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $email;

    /**
     * Roles.
     *
     * @var array<int, string>
     */
    #[ORM\Column(type: 'json')]
    private $roles = [];

    /**
     * Password.
     *
     * @var string|null
     */
    #[ORM\Column(type: 'string')]
    private $password;

    /**
     * Plain Password.
     *
     * @var string|null
     */
    #[Assert\NotBlank]
    private $plainPassword;

    /**
     * Name.
     *
     * @var string|null
     */
    #[Assert\NotBlank]
    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    /**
     * Getter for id.
     *
     * @return int|null Id
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for email.
     *
     * @return string|null Email
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Setter for email.
     *
     * @param string $email Email
     *
     * @return string $email Email
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @return string User email
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * Getter for username.
     *
     * @return string Username
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * Getter for roles.
     *
     * @return array<int, string> Roles
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = UserRole::ROLE_USER->value;

        return array_unique($roles);
    }

    /**
     * Setter for roles.
     *
     * @param array<int, string> $roles Roles
     *
     * @return array<int, string> $roles Roles
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Getter for password.
     *
     * @return string|null Password
     *
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Setter for password.
     *
     * @param string $password User password
     *
     * @return string User password
     */
    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Getter for plain password.
     *
     * @return string|null Password
     */
    public function getPlainPassword(): string
    {
        return $this->plainPassword;
    }

    /**
     * Setter for plain password.
     *
     * @param string $password User password
     *
     * @return string User password
     */
    public function setPlainPassword(string $password): self
    {
        $this->plainPassword = $password;

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

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @return string|null Salt
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * Setter for name.
     *
     * @param string Name $name
     *
     * @return string Name
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Getter for password.
     *
     * @return string Name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * To string.
     *
     * @return string StringText
     */
    public function __toString(): string
    {
        return $this->email;
    }
}
