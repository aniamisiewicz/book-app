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

use DateTime;
use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Class BookService.
 */
class BookService implements BookServiceInterface
{
    /*
    *Book Repository
    */
    private $bookRepository;

    public const PAGE_SIZE = 10;

    /**
     * Constructor.
     *
     * @param BookRepository $bookRepository Book repository
     */
    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    /**
     * @param $page
     *
     * @return Book[] Returns an array of Book objects
     */
    public function findAll(int $page)
    {
        $books = $this->bookRepository;
        $query = $books->createQueryBuilder('u')
                            ->getQuery();

        $pageSize = 10;
        $paginator = new Paginator($query);

        $paginator
            ->getQuery()
            ->setFirstResult($pageSize * ($page)) // set the offset
            ->setMaxResults($pageSize); // set the limit

        $books = [];

        foreach ($paginator as $pageItem) {
            $books[] = $pageItem;
        }

        return $books;
    }

    /**
     * Save entity.
     *
     * @param Book $book Book entity
     */
    public function add(Book $book)
    {
        $book->setCreatedAt(new DateTime());
        $this->bookRepository->add($book);
    }

    /**
     * Edit entity.
     *
     * @param Book $book Book entuty
     */
    public function edit(Book $book)
    {
        $this->bookRepository->add($book);
    }

    /**
     * Query all.
     *
     * @param $filters Filters
     *
     * @return QueryBuilder Query builder
     */
    public function queryAll(array $filters)
    {
        return $this->bookRepository->queryAll($filters);
    }

    /**
     * Delete entity.
     *
     * @param Book $book Book entuty
     */
    public function delete(Book $book)
    {
        $this->bookRepository->remove($book);
    }

    /**
     * Find entity.
     *
     * @param int $id Book id
     *
     * @return Book Book
     */
    public function findOneById(int $id)
    {
        return $this->bookRepository->findOneById($id);
    }
}
