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

use App\Entity\Category;

/**
 * Interface Category Service.
 */
interface CategoryServiceInterface
{
    /**
     * @param int $page Page
     *
     * @return Category[] Returns an array of Category objects
     */
    public function findAll(int $page);

    /**
     * Save entity.
     *
     * @param Category $category Category entity
     */
    public function add(Category $category);

    /**
     * Edit entity.
     *
     * @param Category $category Category entity
     */
    public function edit(Category $category);

    /**
     * Delete entity.
     *
     * @param Category $category Category entity
     */
    public function delete(Category $category);

    /**
     * Find by id.
     *
     * @param int $id Category id
     *
     * @return Category|null Category entity
     *
     * @throws NonUniqueResultException
     */
    public function findOneById(int $id): ?Category;

    /**
     * Query all.
     *
     * @return QueryBuilder Query builder
     */
    public function queryAll();

    // ...
    /**
     * Can Category be deleted?
     *
     * @param Category $category Category entity
     *
     * @return bool Result
     */
    public function canBeDeleted(Category $category): bool;
}
