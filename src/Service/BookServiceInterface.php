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

use App\Entity\Book;

/**
 * Book service interface.
 */
interface BookServiceInterface
{
    /**
     * @param int $page Page
     *
     * @return Book[] Returns an array of Book objects
     */
    public function findAll(int $page);

    /**
     * Save entity.
     *
     * @param Book $book Book entity
     */
    public function add(Book $book);

    /**
     * Edit entity.
     *
     * @param Book $book Book entuty
     */
    public function edit(Book $book);

    /**
     * Query all.
     *
     * @param array $filters Filters
     *
     * @return QueryBuilder Query builder
     */
    public function queryAll(array $filters);

    /**
     * Delete entity.
     *
     * @param Book $book Book entuty
     */
    public function delete(Book $book);

    /**
     * Find  entity.
     *
     * @param int $id Book id
     */
    public function findOneById(int $id);
}
