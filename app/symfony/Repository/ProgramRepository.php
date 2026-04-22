<?php

namespace App\Repository;

use App\Entity\Program;
use Doctrine\ORM\EntityRepository;

/**
 * ProgramRepository
 * 
 * Custom repository methods for Program entity queries
 */
class ProgramRepository extends EntityRepository
{
    /**
     * Find all programs ordered by title
     * 
     * @return Program[]
     */
    public function findAllOrdered(): array
    {
        return $this->findBy([], ['title' => 'ASC']);
    }

    /**
     * Check if code already exists
     * 
     * @param string $code Program code
     * @param int|null $excludeId Program ID to exclude from check
     * @return bool
     */
    public function codeExists(string $code, ?int $excludeId = null): bool
    {
        $query = $this->createQueryBuilder('p')
            ->select('COUNT(p.programId)')
            ->where('p.code = :code')
            ->setParameter('code', $code);

        if ($excludeId !== null) {
            $query->andWhere('p.programId != :id')
                ->setParameter('id', $excludeId);
        }

        return (int) $query->getQuery()->getSingleScalarResult() > 0;
    }
}
