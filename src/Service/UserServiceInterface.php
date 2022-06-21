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

/**
 * Interface User Service.
 */
interface UserServiceInterface
{
    /**
     * @return User[] Returns an array of User objects
     */
    public function findAll();

    /**
     * Save entity.
     *
     * @param User $user User entity
     */
    public function add(User $user);

    /**
     * Edit entity.
     *
     * @param User $user User entity
     */
    public function edit(User $user);

    /**
     * Delete entity.
     *
     * @param User $user User entity
     */
    public function delete(User $user);

    /**
     * Finds user by id.
     *
     * @param int $id Id
     */
    public function findOneById(int $id);
}
