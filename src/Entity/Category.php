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

use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Category class.
 */
#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
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
     * Name.
     *
     * @var string|null
     */
    #[Assert\NotBlank]
    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    /**
     * Constructor.
     */
    public function __construct()
    {
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
     * Getter for name.
     *
     * @return string|null Name
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Setter for Name.
     *
     * @param string|null $name Name
     *
     * @return string|null $name Name
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
