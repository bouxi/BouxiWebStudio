<?php

namespace App\Repository;

use App\Entity\ContactMessage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Repository pour effectuer des requêtes sur les messages de contact.
 */
class ContactMessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContactMessage::class);
    }

    /**
     * Retourne les derniers messages de contact envoyés
     * par une adresse e-mail donnée (triés du plus récent au plus ancien).
     *
     * @param string $email Adresse e-mail à filtrer
     * @param int $limit    Nombre maximum de résultats à retourner
     *
     * @return ContactMessage[]
     */
    public function findLastByEmail(string $email, int $limit = 5): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.email = :email')
            ->setParameter('email', $email)
            ->orderBy('c.createdAt', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}
