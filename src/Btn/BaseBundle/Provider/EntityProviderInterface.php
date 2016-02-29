<?php

namespace Btn\BaseBundle\Provider;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

interface EntityProviderInterface
{
    public function setEntityManager(EntityManager $em);
    public function getEntityManager();
    public function getClass();
    public function getAlias();
    public function createQueryBuilder();
    public function setRepository(EntityRepository $repository);
    public function getRepository();
    public function create();
    public function supports($class);
    public function delete($entity, $andFlush = true);
    public function save($entity, $andFlush = true);
    public function find($id);
}
