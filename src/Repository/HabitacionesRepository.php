<?php

namespace App\Repository;

use App\Entity\Habitaciones;
use App\Entity\Reservas;
use App\Entity\TiposHabitacion;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Habitaciones>
 *
 * @method Habitaciones|null find($id, $lockMode = null, $lockVersion = null)
 * @method Habitaciones|null findOneBy(array $criteria, array $orderBy = null)
 * @method Habitaciones[]    findAll()
 * @method Habitaciones[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HabitacionesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Habitaciones::class);
    }

    public function add(Habitaciones $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Habitaciones $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Obtiene las habitaciones disponibles según capacidad y fechas
     *
     * @param $params
     * @return mixed
     */
    public function findDisponibles($params)
    {
        $expr = $this->_em->getExpressionBuilder();

        /* Busca los tipos de habitación que NO tengan capacidad para el número de huéspedes */
        $sub2 = $this->_em->createQueryBuilder()
            ->select('t')
            ->from(TiposHabitacion::class, 't')
            ->andWhere('t.capacidad < :num_huespedes')
        ;

        /* Busca las reservas que coincidan en fechas con el rango de fechas solicitado */
        $sub = $this->_em->createQueryBuilder()
            ->select('r')
            ->from(Reservas::class, 'r')
            ->andWhere('r.fecha_entrada BETWEEN :fecha_entrada AND :fecha_salida')
            ->orWhere('r.fecha_salida BETWEEN :fecha_entrada AND :fecha_salida')
            ->orWhere('r.fecha_entrada >= :fecha_entrada AND r.fecha_salida <= :fecha_salida')
            ->setParameters([
                'fecha_entrada' => $params['fecha_entrada'],
                'fecha_salida'  => $params['fecha_salida']
            ])
        ;

        $habs_no_disp = [];
        foreach ($sub->getQuery()->getResult() as $key => $res_hab) {
            $habs_no_disp[] = $res_hab->getHabitacion()->first()->getId();
        }

        $qb = $this->_em->createQueryBuilder()
            ->select('h')
            ->from(Habitaciones::class, 'h')
            ->andWhere($expr->notIn('h.tipo_habitacion', $sub2->getDQL()))
            ->setParameters([
                'num_huespedes' => $params['num_huespedes']
            ]);

        if(count($habs_no_disp) > 0) {
            $qb->andWhere('h.id NOT IN (:habs_no_disp)');
            $qb->setParameters([
                'num_huespedes' => $params['num_huespedes'],
                'habs_no_disp'  => $habs_no_disp
            ]);
        }
        return $qb->getQuery()->getResult();
    }
}
