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

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Book class.
 */
#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
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
     * Title.
     *
     * @var string|null
     */
    #[Assert\NotBlank]
    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    /**
     * Auhor.
     *
     * @var string|null
     */
    #[Assert\NotBlank]
    #[ORM\Column(type: 'string', length: 255)]
    private $author;

    /**
     * Created at.
     *
     * @var DateTimeImmutable|null
     *
     * @psalm-suppress PropertyNotSetInConstructor
     */
    #[ORM\Column(type: 'datetime')]
    private $createdAt;

    /**
     * Category.
     *
     * @var Category|null
     */
    #[Assert\NotBlank]
    #[ORM\ManyToOne(targetEntity: Category::class, fetch: 'EXTRA_LAZY')]
    #[ORM\JoinColumn(nullable: false)]
    private $category;

    /**
     * Comments.
     *
     * @var Category|null
     *
     * @psalm-suppress PropertyNotSetInConstructor
     */
    #[ORM\OneToMany(mappedBy: 'book', targetEntity: Comment::class)]
    private $comments;

    /**
     * Creator.
     *
     * @var User|null
     */
    #[ORM\ManyToOne(targetEntity: User::class)]
    private $creator;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

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
     * Getter for Title.
     *
     * @return string|null Id
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Setter for Id.
     *
     * @param string|null Title $title
     *
     * @return string $title
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Getter for Author.
     *
     * @return string|null Author $author
     */
    public function getAuthor(): ?string
    {
        return $this->author;
    }

    /**
     * Seter for Title.
     *
     * @param string|null Author $author
     *
     * @return string|null Author $author
     */
    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Getter for Created At.
     *
     * @return DateTimeImmutable|null $createdAt Created at
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt->format("Y-m-d\TH:i:sO");
    }

    /**
     * Setter for Created At.
     *
     * @param DateTimeImmutable|null $createdAt Created at
     *
     * @return DateTimeImmutable|null $createdAt Created at
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Getter for Category.
     *
     * @return Category|null $category
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * Setter for Category.
     *
     * @param Category|null $category Category
     *
     * @return Category|null $category
     */
    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Getter for Category name.
     *
     * @return string|null $createdAt Created at
     */
    public function getCategoryName(): ?string
    {
        return $this->category->getName();
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    /**
     * Add comment.
     *
     * @param Comment $comment Comment
     *
     * @return Comment Comment
     */
    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setBook($this);
        }

        return $this;
    }

    /**
     * Add comment.
     *
     * @param Comment $comment Comment
     *
     * @return Comment $comment
     */
    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getBook() === $this) {
                $comment->setBook(null);
            }
        }

        return $this;
    }

    /**
     * Getter for Creator.
     *
     * @return User|null $creator
     */
    public function getCreator(): ?User
    {
        return $this->creator;
    }

    /**
     * Setter for Creator.
     *
     * @param User|null $creator User
     *
     * @return User|null $creator
     */
    public function setCreator(?User $creator): self
    {
        $this->creator = $creator;

        return $this;
    }
}
