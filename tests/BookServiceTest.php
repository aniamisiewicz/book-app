<?php
/**
 * Book service tests.
 */

namespace App\Tests\Service;

use App\Entity\Book;
use App\Service\BookService;
use App\Service\CategoryService;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Entity\Category;
use App\Repository\CategoryRepository;




/**
 * Class BookServiceTest.
 */
class BookServiceTest extends KernelTestCase
{
    /**
     * Book repository.
     */
    private ?EntityManagerInterface $entityManager;

    /**
     * Book service.
     */
    private ?BookService $bookService;


    /**
     * Category service.
     */
    private ?CategoryService $categoryService;

    /**
     * Set up test.
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function setUp(): void
    {
        $container = static::getContainer();
        $this->entityManager = $container->get('doctrine.orm.entity_manager');
        $this->bookService = $container->get(BookService::class);
        $container = static::getContainer();
        $this->entityManagerCategory = $container->get('doctrine.orm.entity_manager');
        $this->categoryService = $container->get(CategoryService::class);
        
    }

    /**
     * Test save.
     *
     * @throws ORMException
     */
    public function testSave(): void
    {
        // given
        $expectedBook = new Book();
        $expectedBook->setTitle('Test Book');
        $expectedBook->setAuthor('Test Author');
        $expectedBook->setCreatedAt(new \DateTime()); 
        $category = $this->createCategory(); 
        $expectedBook->setCategory($category);

        // when
        $this->bookService->add($expectedBook);

        // then
        $expectedBookId = $expectedBook->getId();
        $resultBook = $this->entityManager->createQueryBuilder()
            ->select('book')
            ->from(Book::class, 'book')
            ->where('book.id = :id')
            ->setParameter(':id', $expectedBookId, Types::INTEGER)
            ->getQuery()
            ->getSingleResult();

        $this->assertEquals($expectedBook, $resultBook);
       // $this->removeCategory($category->getId()); 
    }

        /**
     * Test edit.
     *
     * @throws ORMException
     */
    public function testEdit(): void
    {
        // given
        $expectedBook = new Book();
        $expectedBook->setTitle('Test Book');
        $expectedBook->setAuthor('Test Author');
        $expectedBook->setCreatedAt(new \DateTime()); 
        $category = $this->createCategory(); 
        $expectedBook->setCategory($category);

        // when
        $this->bookService->edit($expectedBook);

        // then
        $expectedBookId = $expectedBook->getId();
        $resultBook = $this->entityManager->createQueryBuilder()
            ->select('book')
            ->from(Book::class, 'book')
            ->where('book.id = :id')
            ->setParameter(':id', $expectedBookId, Types::INTEGER)
            ->getQuery()
            ->getSingleResult();

        $this->assertEquals($expectedBook, $resultBook);
       // $this->removeCategory($category->getId()); 
    }


    /**
     * Test delete.
     *
     * @throws OptimisticLockException|ORMException
     */
    public function testDelete(): void
    {
        // given
        $bookToDelete = new Book();
        $bookToDelete->setTitle('Test Book');
        $bookToDelete->setAuthor('Test Author');
        $bookToDelete->setCreatedAt(new \DateTime()); 
        $category = $this->createCategory(); 
        $bookToDelete->setCategory($category);
        $this->entityManager->persist($bookToDelete);
        $this->entityManager->flush();
        $deletedBookId = $bookToDelete->getId();

        // when
        $this->bookService->delete($bookToDelete);

        // then
        $resultBook = $this->entityManager->createQueryBuilder()
            ->select('book')
            ->from(Book::class, 'book')
            ->where('book.id = :id')
            ->setParameter(':id', $deletedBookId, Types::INTEGER)
            ->getQuery()
            ->getOneOrNullResult();

        $this->assertNull($resultBook);
       // $this->removeCategory($category->getId()); 

    }

    

    /**
     * Test find by id.
     *
     * @throws ORMException
     */
    public function testFindById(): void
    {
        // given
        $expectedBook = new Book();
        $expectedBook->setTitle('Test Book');
        $expectedBook->setAuthor('Test Author');
        $expectedBook->setCreatedAt(new \DateTime()); 
        $category = $this->createCategory(); 
        $expectedBook->setCategory($category);
        $this->entityManager->persist($expectedBook);
        $this->entityManager->flush();
        $expectedBookId = $expectedBook->getId();

        // when
        $resultBook = $this->bookService->findOneById($expectedBookId);

        // then
        $this->assertEquals($expectedBook, $resultBook);
       // $this->removeCategory($category->getId()); 
    }

  
    /**
     * Test pagination empty list.
     */
    public function testGetPaginatedList(): void
    {
        // given
        $page = 1;
        $dataSetSize = 3;
        $expectedResultSize = 10;

        $counter = 0;
        $category = $this->createCategory(); 
        while ($counter < $dataSetSize) {
            $book = new Book();
            $book->setTitle('Test Book #'.$counter);
            $book->setAuthor('Test Author #'.$counter);
            $book->setCategory($category);
            $book->setCreatedAt(new \DateTime()); 
            $this->bookService->add($book);

            ++$counter;
        }
        // when
        $result = $this->bookService->findAll($page);

        // then
        $this->assertEquals($expectedResultSize, count($result));
        //$this->removeCategory($category->getId()); 

    }

    public function createCategory(): Category
    {
        $category = new Category();
        $category->setName('Test Category');
        $this->categoryService->add($category); 
        return $category;
    }

}

