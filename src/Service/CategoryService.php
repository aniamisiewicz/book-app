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
use App\Repository\CategoryRepository;
use App\Repository\BookRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Category service.
 */
class CategoryService implements CategoryServiceInterface
{
    /**
     * Category repository.
     */
    private $categoryRepository;

    public const PAGE_SIZE = 10;

    /**
     * Book repository.
     */
    private BookRepository $bookRepository;

    /**
     * Constructor.
     *
     * @param CategoryRepository $categoryRepository CategoryRepository
     * @param BookRepository     $bookRepository     BookRepository
     */
    public function __construct(CategoryRepository $categoryRepository, BookRepository $bookRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->bookRepository = $bookRepository;
    }

    /**
     * @param $page
     *
     * @return Category[] Returns an array of Category objects
     */
    public function findAll(int $page)
    {
        $categories = $this->categoryRepository;
        $query = $categories->createQueryBuilder('u')
                            ->getQuery();

        $pageSize = 10;
        $paginator = new Paginator($query);

        $totalItems = count($paginator);

        $paginator
            ->getQuery()
            ->setFirstResult($pageSize * ($page)) // set the offset
            ->setMaxResults($pageSize); // set the limit

        $categories = [];

        foreach ($paginator as $pageItem) {
            $categories[] = $pageItem;
        }

        return $categories;
    }

    /**
     * Save entity.
     *
     * @param Category $category Category entity
     */
    public function add(Category $category)
    {
        $this->categoryRepository->add($category);
    }

    /**
     * Edit entity.
     *
     * @param Category $category Category entity
     */
    public function edit(Category $category)
    {
        $this->categoryRepository->add($category);
    }

    /**
     * Delete entity.
     *
     * @param Category $category Category entity
     */
    public function delete(Category $category)
    {
        $this->categoryRepository->remove($category);
    }

    /**
     * Find by id.
     *
     * @param int $id Category id
     *
     * @return Category|null Category entity
     *
     * @throws NonUniqueResultException
     */
    public function findOneById(int $id): ?Category
    {
        return $this->categoryRepository->findOneById($id);
    }

    /**
     * Query all.
     *
     * @return QueryBuilder Query builder
     */
    public function queryAll()
    {
        return $this->categoryRepository->queryAll();
    }

    // ...
    /**
     * Can Category be deleted?
     *
     * @param Category $category Category entity
     *
     * @return bool Result
     */
    public function canBeDeleted(Category $category): bool
    {
        try {
            $result = $this->bookRepository->countByCategory($category);

            return !($result > 0);
        } catch (NoResultException|NonUniqueResultException) {
            return false;
        }
    }
}
