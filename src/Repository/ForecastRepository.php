<?php

namespace App\Repository;

use App\Entity\City;
use App\Entity\Forecast;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Result;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @extends ServiceEntityRepository<Forecast>
 *
 * @method Forecast|null find($id, $lockMode = null, $lockVersion = null)
 * @method Forecast|null findOneBy(array $criteria, array $orderBy = null)
 * @method Forecast[]    findAll()
 * @method Forecast[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ForecastRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Forecast::class);
    }
    public function findByLocalization(City $city)
    {
        $gb = $this->createQueryBuilder('m');
        $gb->where('m.city = :city')
            ->setParameter('city',$city)
            ->andWhere('m.Date > :date')
            ->setParameter('date', (new \DateTime())->format("Y-m-d H:i:s"));

        $query = $gb->getQuery();
        return $query->getResult();
    }
}
