<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\News;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

final class NewsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $managerRegistry)
    {
        parent::__construct($managerRegistry, News::class);
    }

    /**
     * @param iterable $newsCollection
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function persistAndFlush(iterable $newsCollection): void
    {
        $persistCount = 0;
        foreach ($newsCollection as $news) {
            $this->_em->persist($news);
            ++$persistCount;
            if (0 === $persistCount % 100) {
                $this->_em->flush();
            }
        }
        $this->_em->flush();
    }
}
