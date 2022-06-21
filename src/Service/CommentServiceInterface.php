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
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

/**
 * Interface Comment Service.
 */
interface CommentServiceInterface
{
    /**
     * Adds comment.
     *
     * @param Comment $entity Comment
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Comment $entity): void;

    /**
     * Remove comment.
     *
     * @param Comment $entity Comment
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Comment $entity): void;
}
