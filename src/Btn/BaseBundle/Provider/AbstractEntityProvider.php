<?php

namespace Btn\BaseBundle\Provider;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

abstract class AbstractEntityProvider implements EntityProviderInterface
{
    /** @var \Doctrine\ORM\EntityManager $em */
    protected $em;
    /** @var string $class */
    protected $class;
    /** @var \Doctrine\ORM\EntityRepository $repository */
    protected $repository;

    /**
     * @param string           $class
     * @param EntityManager    $em
     * @param EntityRepository $repository
     */
    public function __construct($class, EntityManager $em = null, EntityRepository $repository = null)
    {
        $this->class      = $class;
        $this->em         = $em;
        $this->repository = $repository;
    }

    /**
     * @param EntityManager $em
     *
     * @return $this
     */
    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;

        return $this;
    }

    /**
     *
     */
    public function getEntityManager()
    {
        return $this->em;
    }

    /**
     *
     */
    public function getClass()
    {
        if (!$this->class) {
            throw new \Exception('Class name not defined');
        }

        return $this->class;
    }

    /**
     *
     */
    public function getAlias()
    {
        $class = $this->getClass();
        $className = substr($class, strrpos($class, '\\') + 1);

        return strtolower(preg_replace('~[^A-Z]~', '', $className));
    }

    /**
     *
     */
    public function createQueryBuilder()
    {
        return $this->getRepository()->createQueryBuilder($this->getAlias());
    }

    /**
     * @param EntityRepository $repository
     */
    public function setRepository(EntityRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     *
     */
    public function getRepository()
    {
        return $this->repository ? $this->repository : $this->em->getRepository($this->getClass());
    }

    /**
     *
     */
    public function create()
    {
        $class = $this->getClass();

        $args = func_get_args();
        if ($args) {
            return call_user_func_array(array(new \ReflectionClass($class), 'newInstance'), $args);
        }

        $entity = new $class();

        return $entity;
    }

    /**
     * @param $id
     *
     * @return null|object
     */
    public function find($id)
    {
        return $this->getRepository()->find($id);
    }

    /**
     * @param $class
     *
     * @return bool
     * @throws \Exception
     */
    public function supports($class)
    {
        return is_a($class, $this->getClass()) ? true : false;
    }

    /**
     * @param      $entity
     * @param bool $andFlush
     *
     * @throws \Exception
     */
    public function delete($entity, $andFlush = true)
    {
        $this->checkSupportOrThrowException($entity);

        $this->em->remove($entity);

        if ($andFlush) {
            $this->em->flush();
        }
    }

    /**
     * @param      $entity
     * @param bool $andFlush
     *
     * @throws \Exception
     */
    public function save($entity, $andFlush = true)
    {
        $this->checkSupportOrThrowException($entity);

        if (!$entity->getId()) {
            $this->em->persist($entity);
        }

        if ($andFlush) {
            $this->em->flush($entity);
        }
    }

    /**
     * @param $entity
     *
     * @throws \Exception
     */
    protected function checkSupportOrThrowException($entity)
    {
        if (!is_object($entity)) {
            throw new \Exception(sprintf(
                'Invalid argument for "%s". Object required, "%s" given.',
                __CLASS__,
                gettype($entity)
            ));
        }

        if (!$this->supports($entity)) {
            throw new \Exception(sprinf(
                'This provider only supports "%s", "%s" is given.',
                $this->getClass(),
                get_class($entity)
            ));
        }
    }
}
