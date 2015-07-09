<?php

namespace BugBundle\Entity;

use Doctrine\ORM\EntityRepository;


/**
 * ProjectRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProjectRepository extends EntityRepository
{
    public function getProjectsByUserQuery(User $user)
    {
        $qb = $this->createQueryBuilder('p')
            ->leftJoin('p.members', 'members');
        $qb->where($qb->expr()->orX(
            $qb->expr()->in('members', ':user'),
            $qb->expr()->eq('p.creator', ':user')

        ))
            ->setParameter('user', $user);
        return $qb->getQuery();
    }


    public function getAllProjectsQuery()
    {
        return $this->getEntityManager()->createQuery("SELECT p FROM BugBundle:project p");
    }

    /**
     * @param User $user
     * @return array
     */
    public function getProjectsByUser(User $user)
    {
        return $this->getProjectsByUserQuery($user)->getResult();

    }
}
