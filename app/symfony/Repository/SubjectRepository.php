<?php

namespace App\Repository;

use App\Entity\Subject;
use Doctrine\ORM\EntityRepository;

/**
 * SubjectRepository
 * 
 * Custom repository methods for Subject entity queries
 */
class SubjectRepository extends EntityRepository
{
    /**
     * Find all subjects ordered by title
     * 
     * @return Subject[]
     */
    public function findAllOrdered(): array
    {
        return $this->findBy([], ['title' => 'ASC']);
    }

    /**
     * Check if code already exists
     * 
     * @param string $code Subject code
     * @param int|null $excludeId Subject ID to exclude from check
     * @return bool
     */
    public function codeExists(string $code, ?int $excludeId = null): bool
    {
        $query = $this->createQueryBuilder('s')
            ->select('COUNT(s.subjectId)')
            ->where('s.code = :code')
            ->setParameter('code', $code);

        if ($excludeId !== null) {
            $query->andWhere('s.subjectId != :id')
                ->setParameter('id', $excludeId);
        }

        return (int) $query->getQuery()->getSingleScalarResult() > 0;
    }
}
