<?php

namespace App\Repository;

use App\Entity\Booking;
use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Booking>
 */
class BookingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Booking::class);
    }

    /**
     * Count event bookings.
     */
    public function countEventBooking($event_id) {
        return $this->createQueryBuilder('e')
            ->andWhere('e.event_id = :val')
            ->setParameter('val', $event_id)
            ->select('count(e.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

}
