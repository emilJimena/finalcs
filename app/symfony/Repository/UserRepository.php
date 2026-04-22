<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\ORM\EntityRepository;

/**
 * UserRepository
 * 
 * Custom repository methods for User entity queries
 */
class UserRepository extends EntityRepository
{
    /**
     * Find user by username
     * 
     * @param string $username Username
     * @return User|null
     */
    public function findByUsername(string $username): ?User
    {
        return $this->findOneBy(['username' => $username]);
    }

    /**
     * Find all users ordered by creation date
     * 
     * @return User[]
     */
    public function findAllOrdered(): array
    {
        return $this->findBy([], ['createdOn' => 'DESC']);
    }

    /**
     * Check if username already exists
     * 
     * @param string $username Username
     * @param int|null $excludeId User ID to exclude from check
     * @return bool
     */
    public function usernameExists(string $username, ?int $excludeId = null): bool
    {
        $query = $this->createQueryBuilder('u')
            ->select('COUNT(u.id)')
            ->where('u.username = :username')
            ->setParameter('username', $username);

        if ($excludeId !== null) {
            $query->andWhere('u.id != :id')
                ->setParameter('id', $excludeId);
        }

        return (int) $query->getQuery()->getSingleScalarResult() > 0;
    }
}
