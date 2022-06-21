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

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Comment class.
 */
#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
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
    #[ORM\Column(type: 'string', length: 255)]
    private $email;

    /**
     * Nick.
     *
     * @var string|null
     */
    #[Assert\NotBlank]
    #[ORM\Column(type: 'string', length: 255)]
    private $nick;

    /**
     * Content.
     *
     * @var string|null
     */
    #[Assert\NotBlank]
    #[ORM\Column(type: 'string', length: 255)]
    private $content;

    /**
     * Book.
     *
     * @var Book|null
     */
    #[ORM\ManyToOne(targetEntity: Book::class, inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private $book;

    /**
     * Getter for Id.
     *
     * @return int|null Id
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for Email.
     *
     * @return string|null Email
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Setter for Email.
     *
     * @param string|null $email
     *
     * @return string|null Email
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Getter for Nick.
     *
     * @return string|null Nick
     */
    public function getNick(): ?string
    {
        return $this->nick;
    }

    /**
     * Setter for Nick.
     *
     * @param string|null $nick Nick
     *
     * @return string|null Nick
     */
    public function setNick(string $nick): self
    {
        $this->nick = $nick;

        return $this;
    }

    /**
     * Getter for Content.
     *
     * @return string|null Content
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * Setter for Content.
     *
     * @param string|null $content content
     *
     * @return string|null content
     */
    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Getter for Book.
     *
     * @return Book|null Book
     */
    public function getBook(): ?Book
    {
        return $this->book;
    }

    /**
     * Setter for Nick.
     *
     * @param string|null $book Book
     *
     * @return string|null Book
     */
    public function setBook(?Book $book): self
    {
        $this->book = $book;

        return $this;
    }
}
