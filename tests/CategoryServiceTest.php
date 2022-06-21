<?php
/**
 * Category service tests.
 */

namespace App\Tests\Service;

use App\Entity\Category;
use App\Service\CategoryService;
use App\Service\CategoryServiceInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class CategoryServiceTest.
 */
class CategoryServiceTest extends KernelTestCase
{
    /**
     * Category repository.
     */
    private ?EntityManagerInterface $entityManager;

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
        $expectedCategory = new Category();
        $expectedCategory->setName('Test Category');

        // when
        $this->categoryService->add($expectedCategory);

        // then
        $expectedCategoryId = $expectedCategory->getId();
        $resultCategory = $this->entityManager->createQueryBuilder()
            ->select('category')
            ->from(Category::class, 'category')
            ->where('category.id = :id')
            ->setParameter(':id', $expectedCategoryId, Types::INTEGER)
            ->getQuery()
            ->getSingleResult();

        $this->assertEquals($expectedCategory, $resultCategory);
    }


    /**
     * Test edit.
     *
     * @throws ORMException
     */
    public function testEdit(): void
    {
        // given
        $expectedCategory = new Category();
        $expectedCategory->setName('Test Category Edited');

        // when
        $this->categoryService->edit($expectedCategory);

        // then
        $expectedCategoryId = $expectedCategory->getId();
        $resultCategory = $this->entityManager->createQueryBuilder()
            ->select('category')
            ->from(Category::class, 'category')
            ->where('category.id = :id')
            ->setParameter(':id', $expectedCategoryId, Types::INTEGER)
            ->getQuery()
            ->getSingleResult();

        $this->assertEquals($expectedCategory, $resultCategory);
    }

    /**
     * Test delete.
     *
     * @throws OptimisticLockException|ORMException
     */
    public function testDelete(): void
    {
        // given
        $categoryToDelete = new Category();
        $categoryToDelete->setName('Test Category');
        $this->entityManager->persist($categoryToDelete);
        $this->entityManager->flush();
        $deletedCategoryId = $categoryToDelete->getId();

        // when
        $this->categoryService->delete($categoryToDelete);

        // then
        $resultCategory = $this->entityManager->createQueryBuilder()
            ->select('category')
            ->from(Category::class, 'category')
            ->where('category.id = :id')
            ->setParameter(':id', $deletedCategoryId, Types::INTEGER)
            ->getQuery()
            ->getOneOrNullResult();

        $this->assertNull($resultCategory);
    }

    /**
     * Test find by id.
     *
     * @throws ORMException
     */
    public function testFindById(): void
    {
        // given
        $expectedCategory = new Category();
        $expectedCategory->setName('Test Category');
        $this->entityManager->persist($expectedCategory);
        $this->entityManager->flush();
        $expectedCategoryId = $expectedCategory->getId();

        // when
        $resultCategory = $this->categoryService->findOneById($expectedCategoryId);

        // then
        $this->assertEquals($expectedCategory, $resultCategory);
    }
 
    /**
     * Test find by name.
     *
     * @throws ORMException
     */
/*
    public function testFindByName()
    {
        $expectedCategory = new Category();
        $expectedCategory->setName('Test Category Name');
        $this->categoryService->add($expectedCategory);
        $expectedCategoryId = $expectedCategory->getId();

        $category = $this->entityManager
            ->getRepository(Category::class)
            ->findOneBy(['name' => 'Test Category Name'])
        ;

        $this->assertSame($expectedCategoryId, $category->getId());
    } */



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
        while ($counter < $dataSetSize) {
            $category = new Category();
            $category->setName('Test Category #'.$counter);
            $this->categoryService->add($category);

            ++$counter;
        }
        // when
        $result = $this->categoryService->findAll($page);

        // then
        $this->assertEquals($expectedResultSize, count($result));
    }

    // other tests for paginated list
}
