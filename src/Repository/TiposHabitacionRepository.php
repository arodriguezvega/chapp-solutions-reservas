<?php

namespace App\Repository;

use App\Entity\TiposHabitacion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TiposHabitacion>
 *
 * @method TiposHabitacion|null find($id, $lockMode = null, $lockVersion = null)
 * @method TiposHabitacion|null findOneBy(array $criteria, array $orderBy = null)
 * @method TiposHabitacion[]    findAll()
 * @method TiposHabitacion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TiposHabitacionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TiposHabitacion::class);
    }

    public function add(TiposHabitacion $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TiposHabitacion $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
