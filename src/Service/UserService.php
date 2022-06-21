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

use App\Entity\User;
use App\Repository\UserRepository;

/**
 * User service.
 */
class UserService implements UserServiceInterface
{
    /**
     * User repository.
     */
    private $userRepository;

    /**
     * Constructor.
     *
     * @param UserRepository $userRepository UserRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return User[] Returns an array of User objects
     */
    public function findAll()
    {
        $users = $this->userRepository;
        $query = $users->createQueryBuilder('u')
                            ->getQuery();

        return $query->getResult();
    }

    /**
     * Save entity.
     *
     * @param User $user User entity
     */
    public function add(User $user)
    {
        $this->userRepository->add($user);
    }

    /**
     * Edit entity.
     *
     * @param User $user User entity
     */
    public function edit(User $user)
    {
        $this->userRepository->add($user);
    }

    /**
     * Delete entity.
     *
     * @param User $user User entity
     */
    public function delete(User $user)
    {
        $this->userRepository->remove($user);
    }

    /**
     * Finds user by id.
     *
     * @param $id Id
     *
     * @return User User
     */
    public function findOneById(int $id)
    {
        return $this->userRepository->findOneById($id);
    }
}
