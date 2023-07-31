<?php

namespace App\Repository;

use App\Entity\Contrat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Twilio\Rest\Client;
/**
 * @extends ServiceEntityRepository<Contrat>
 *
 * @method Contrat|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contrat|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contrat[]    findAll()
 * @method Contrat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContratRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contrat::class);
    }

    public function save(Contrat $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Contrat $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    
  
     public function findByidcontrat ($value){
       $query=$this->createQueryBuilder('c')
                    ->Where( 'c.id LIKE :value')
                  ->setParameter('value', $value)
                   ->getQuery();
       return $query->getResult();
    }
    public function search($nom) {
        $qb=  $this->createQueryBuilder('s')
            ->where('s.NomClient LIKE :x')
            ->setParameter('x',$nom);
        return $qb->getQuery()
            ->getResult();
    }



    public function countByDate()
    {
        $query=$this->createQueryBuilder('c');
        $query
                ->select('SUBSTRING(c.Datededebut,1,10) as datecontrat , COUNT(c) as count')
                ->groupBy('datecontrat');
                return $query->getQuery()->getResult();


    }

    public  function sms(){
        // Your Account SID and Auth Token from twilio.com/console
                $sid = 'AC9760881e13cbcf16daf43b3ff689c956';
                $auth_token = 'eca9d423cd3bc59a2b5189080abbf65e';
        // In production, these should be environment variables. E.g.:
        // $auth_token = $_ENV["TWILIO_AUTH_TOKEN"]
        // A Twilio number you own with SMS capabilities
                $twilio_number = "+15675571074";
        
                $client = new Client($sid, $auth_token);
                $client->messages->create(
                // the number you'd like to send the message to
                    '+21658068248',
                    [
                        // A Twilio phone number you purchased at twilio.com/console
                        'from' => '+15675571074',
                        // the body of the text message you'd like to send
                        'body' => 'votre contract a été confirmé , merci de nous contacter pour plus de détails!'
                    ]
                );
            }

            public function Triepardate(): array
   {
       return $this->createQueryBuilder('e')
           ->orderBy('e.Datededebut', 'ASC')
           ->getQuery()
           ->getResult()
       ;
   }
//    /**
//     * @return Contrat[] Returns an array of Contrat objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Contrat
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
