<?php

namespace PlaygroundReward\Mapper;

use Doctrine\ORM\EntityManager;
use PlaygroundReward\Options\ModuleOptions;

class RewardRule
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    protected $er;

    /**
     * @var \PlaygroundReward\Options\ModuleOptions
     */
    protected $options;

    public function __construct(EntityManager $em, ModuleOptions $options)
    {
        $this->em      = $em;
        $this->options = $options;
    }

    public function findById($id)
    {
        return $this->getEntityRepository()->find($id);
    }

    public function findByRewardId($reward)
    {
        return $this->getEntityRepository()->findBy(array('reward' => $reward));
    }
    
    public function findBy($array)
    {
        return $this->getEntityRepository()->findBy($array);
    }
    
    public function findRulesByStoryMapping($storyMappingId){
        
        $qb = $this->em->createQueryBuilder();
        $qb->select(array('r'))
        ->from('PlaygroundReward\Entity\RewardRule', 'r')
        ->join('r.storyMappings', 's')
        ->where('s = :storyMapping')
        ->setParameter('storyMapping', $storyMappingId);
        
        return $qb->getQuery()->getResult();
    }

    public function insert($entity)
    {
        return $this->persist($entity);
    }

    public function update($entity)
    {
        return $this->persist($entity);
    }

    protected function persist($entity)
    {
        $this->em->persist($entity);
        $this->em->flush();

        return $entity;
    }

    public function findAll()
    {
        return $this->getEntityRepository()->findAll();
    }

    public function remove($entity)
    {
        $this->em->remove($entity);
        $this->em->flush();
    }

    public function getEntityRepository()
    {
        if (null === $this->er) {
            $this->er = $this->em->getRepository('PlaygroundReward\Entity\RewardRule');
        }

        return $this->er;
    }
}
