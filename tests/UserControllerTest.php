<?php
/**
 * User controller tests.
 */

namespace App\Tests\Controller;
use App\Entity\Enum\UserRole;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;




/**
 * Class HelloControllerTest.
 */
class UserControllerTest extends WebTestCase
{

        /**
     * Test client.
     */
    private KernelBrowser $httpClient;

    public function setUp(): void
    {
        $this->httpClient = static::createClient();
    }


    /**
     * Test '/login' route.
     */
    public function testLoginRoute(): void
    {
         // given
         $expectedStatusCode = 200;

        // when
        $this->httpClient->request('GET', '/login'); 
        
        // then
        $resultHttpStatusCode = $this->httpClient->getResponse()->getStatusCode();
        $this->assertEquals($expectedStatusCode, $resultHttpStatusCode);
    }

     /**
     * Test '/logout' route.
     */
    public function testLogoutRoute(): void
    {
         // given
         $expectedStatusCode = 302;

        // when
        $this->httpClient->request('GET', '/logout'); 
        
        // then
        $resultHttpStatusCode = $this->httpClient->getResponse()->getStatusCode();
        $this->assertEquals($expectedStatusCode, $resultHttpStatusCode);
    }



     /**
     * Test '/user/new' route.
     */
    public function testRegistrationRoute(): void
    {
         // given
         $expectedStatusCode = 200;

        // when
        $this->httpClient->request('GET', '/user/new'); 
        
        // then
        $resultHttpStatusCode = $this->httpClient->getResponse()->getStatusCode();
        $this->assertEquals($expectedStatusCode, $resultHttpStatusCode);
    }

   
        /**
     * Test manage users route for anonymous user.
     */
    public function testManageRouteAnonymousUser(): void
    {
        // given
        $expectedStatusCode = 301;

        // when
        $this->httpClient->request('GET', '/user');
        $resultStatusCode = $this->httpClient->getResponse()->getStatusCode();

        // then
        $this->assertEquals($expectedStatusCode, $resultStatusCode);
    }

    /**
     * Test manage users route for admin user.
     *
     * @throws ContainerExceptionInterface|NotFoundExceptionInterface|ORMException|OptimisticLockException
     */
    public function testManageRouteAdminUser(): void
    {
        // given
        $this->removeUser('admin@email.com');
        $this->removeUser('regular@email.com');
        $expectedStatusCode = 200; 
        $adminUser = $this->createUser([UserRole::ROLE_USER->value, UserRole::ROLE_ADMIN->value], 'admin@email.com');
        $this->httpClient->loginUser($adminUser);

        // when
        $this->httpClient->followRedirects(true);
        $this->httpClient->request('GET', '/user');
        $resultStatusCode = $this->httpClient->getResponse()->getStatusCode();

        // then
        $this->assertEquals($expectedStatusCode, $resultStatusCode);
        $this->removeUser('admin@email.com');
    }

         /**
     * Test edit users route for anonymous user.
     */
    public function testEditRouteAnonymousUser(): void
    {
        // given
        $this->removeUser('regular@email.com');
        $expectedStatusCode = 200;
        $regularUser = $this->createUser([UserRole::ROLE_USER->value], 'regular@email.com');
        $this->httpClient->loginUser($regularUser);

        // when
        $this->httpClient->followRedirects(true);
        $this->httpClient->request('GET', "/user/" . strval($regularUser->getId()) . "/edit");
        $resultStatusCode = $this->httpClient->getResponse()->getStatusCode();

        // then
        $this->assertEquals($expectedStatusCode, $resultStatusCode);
        $this->removeUser('regular@email.com');
    }

    /**
     * Test edit users route for admin user.
     *
     * @throws ContainerExceptionInterface|NotFoundExceptionInterface|ORMException|OptimisticLockException
     */
    public function testEditRouteAdminUser(): void
    {
        // given
        $this->removeUser('admin@email.com');
        $expectedStatusCode = 200; 
        $adminUser = $this->createUser([UserRole::ROLE_USER->value, UserRole::ROLE_ADMIN->value], 'admin@email.com');
        $this->httpClient->loginUser($adminUser);
    

        // when
        $this->httpClient->followRedirects(true);
        $this->httpClient->request('GET', "/user/" . strval($adminUser->getId())  . "/edit");
        $resultStatusCode = $this->httpClient->getResponse()->getStatusCode();

        // then
        $this->assertEquals($expectedStatusCode, $resultStatusCode);
        $this->removeUser('admin@email.com');
    }


     

     
    /**
     * Create user.
     *
     * @param array $roles User roles
     *
     * @return User User entity
     *
     * @throws ContainerExceptionInterface|NotFoundExceptionInterface|ORMException|OptimisticLockException
     */
    private function createUser(array $roles, string $email): User
    {
        $passwordHasher = static::getContainer()->get('security.password_hasher');
        $user = new User();
        $user->setEmail($email);
        $user->setRoles($roles);
        $user->setName('test2');
        $user->setPassword(
            $passwordHasher->hashPassword(
                $user,
                'p@55w0rd'
            )
        );
        $userRepository = static::getContainer()->get(UserRepository::class);
        $userRepository->add($user); 

        return $user;
    }

    private function removeUser(string $email): void
    {
        
        $userRepository = static::getContainer()->get(UserRepository::class);
        $entity = $userRepository->findOneBy(array('email' => $email));


        if ($entity != null){
            $userRepository->remove($entity);
        }

    }
}