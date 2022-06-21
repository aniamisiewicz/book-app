<?php
/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use App\Repository\BookRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

/**
 * Comment service.
 */
class CommentService implements CommentServiceInterface
{
    /**
     * Comment repository.
     */
    private CommentRepository $commentRepository;

    /**
     * Constructor.
     *
     * @param CommentRepository $commentRepository CommentRepository
     * @param BookRepository    $bookRepository    BookRepository
     */
    public function __construct(CommentRepository $commentRepository, BookRepository $bookRepository)
    {
        $this->commentRepository = $commentRepository;
        $this->bookRepository = $bookRepository;
    }

    /**
     * Adds comment.
     *
     * @param Comment $entity Comment
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Comment $entity): void
    {
        $this->commentRepository->add($entity);
    }

    /**
     * Remove comment.
     *
     * @param Comment $entity Comment
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Comment $entity): void
    {
        $this->commentRepository->remove($entity);
    }
}
