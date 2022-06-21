<?php
/**
 * User service tests.
 */

namespace App\Tests\Service;
use App\Entity\Enum\UserRole;
use App\Repository\UserRepository;
use App\Entity\User;
use App\Service\UserService;
use App\Service\UserServiceInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class UserServiceTest.
 */
class UserServiceTest extends KernelTestCase
{
    /**
     * User repository.
     */
    private ?EntityManagerInterface $entityManager;

    /**
     * User service.
     */
    private ?UserService $userService;

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
        $this->userService = $container->get(UserService::class);
    }

    /**
     * Test save.
     *
     * @throws ORMException
     */
    public function testSave(): void
    {
        $this->removeUser();

        // given
        $passwordHasher = static::getContainer()->get('security.password_hasher');
        $user = new User();
        $user->setEmail('test2@example.com');
        $user->setRoles([UserRole::ROLE_USER->value]);
        $user->setName('test2');
        $user->setPassword(
            $passwordHasher->hashPassword(
                $user,
                'p@55w0rd'
            )
        );

        // when
        $this->userService->add($user);

        // then
        $expectedUserId = $user->getId();
        $resultUser = $this->entityManager->createQueryBuilder()
            ->select('user')
            ->from(User::class, 'user')
            ->where('user.id = :id')
            ->setParameter(':id', $expectedUserId, Types::INTEGER)
            ->getQuery()
            ->getSingleResult();

        $this->assertEquals($user, $resultUser);
    }

    /**
     * Test delete.
     *
     * @throws OptimisticLockException|ORMException
     */
    public function testDelete(): void
    {
        $this->removeUser();

        // given
        $passwordHasher = static::getContainer()->get('security.password_hasher');
        $user = new User();
        $user->setEmail('test2@example.com');
        $user->setRoles([UserRole::ROLE_USER->value]);
        $user->setName('test2');
        $user->setPassword(
            $passwordHasher->hashPassword(
                $user,
                'p@55w0rd'
            )
        );
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        $deletedUserId = $user->getId();

        // when
        $this->userService->delete($user);

        // then
        $resultUser = $this->entityManager->createQueryBuilder()
            ->select('user')
            ->from(User::class, 'user')
            ->where('user.id = :id')
            ->setParameter(':id', $deletedUserId, Types::INTEGER)
            ->getQuery()
            ->getOneOrNullResult();

        $this->assertNull($resultUser);
    }

    /**
     * Test find by id.
     *
     * @throws ORMException
     */
    public function testFindById(): void
    {
        $this->removeUser();

        // given
        $passwordHasher = static::getContainer()->get('security.password_hasher');
        $user = new User();
        $user->setEmail('test2@example.com');
        $user->setRoles([UserRole::ROLE_USER->value]);
        $user->setName('test2');
        $user->setPassword(
            $passwordHasher->hashPassword(
                $user,
                'p@55w0rd'
            )
        );
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        $expectedUserId = $user->getId();

        // when
        $resultUser = $this->userService->findOneById($expectedUserId);

        // then
        $this->assertEquals($user, $resultUser);
    }



    // other tests for paginated list
    private function removeUser(): void
    {
        
        $userRepository = static::getContainer()->get(UserRepository::class);
        $entity = $userRepository->findOneBy(array('email' => 'test2@example.com'));


        if ($entity != null){
            $userRepository->remove($entity);
        }

    }


    /**
     * Test find by name.
     *
     * @throws ORMException
     */

    public function testFindByName()
    {
        $this->removeUser();
        $passwordHasher = static::getContainer()->get('security.password_hasher');
        $user = new User();
        $user->setEmail('test2@example.com');
        $user->setRoles([UserRole::ROLE_USER->value]);
        $user->setName('test2');
        $user->setPassword(
            $passwordHasher->hashPassword(
                $user,
                'p@55w0rd'
            )
        );
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        $userId = $user->getId();

        $user = $this->entityManager
            ->getRepository(User::class)
            ->findOneBy(['name' => 'test2'])
        ;

        $this->assertSame($userId, $user->getId());
    }

}
