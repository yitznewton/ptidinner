<?php

namespace DinnerBundle\Tests\Transaction;

use Doctrine\Common\Persistence\ObjectManager;

class MockObjectManager implements ObjectManager
{
    private $persisted = [];
    private $flushed = [];

    public function persist($object): void
    {
        $this->persisted[] = $object;
    }

    public function flush(): void
    {
        $this->flushed = $this->persisted;
        $this->persisted = [];
    }

    public function isPersisted($test): bool
    {
        return in_array($test, $this->persisted);
    }

    public function isFlushed($test): bool
    {
        return in_array($test, $this->flushed);
    }

    public function find($className, $id)
    {
        throw new \BadMethodCallException('find() not yet implemented');
    }

    public function remove($object)
    {
        throw new \BadMethodCallException('remove() not yet implemented');
    }

    public function merge($object)
    {
        throw new \BadMethodCallException('merge() not yet implemented');
    }

    public function clear($objectName = null)
    {
        throw new \BadMethodCallException('clear() not yet implemented');
    }

    public function detach($object)
    {
        throw new \BadMethodCallException('detach() not yet implemented');
    }

    public function refresh($object)
    {
        throw new \BadMethodCallException('refresh() not yet implemented');
    }

    public function getRepository($className)
    {
        throw new \BadMethodCallException('getRepository() not yet implemented');
    }

    public function getClassMetadata($className)
    {
        throw new \BadMethodCallException('getClassMetadata() not yet implemented');
    }

    public function getMetadataFactory()
    {
        throw new \BadMethodCallException('getMetadataFactory() not yet implemented');
    }

    public function initializeObject($obj)
    {
        throw new \BadMethodCallException('initializeObject() not yet implemented');
    }

    public function contains($object)
    {
        throw new \BadMethodCallException('contains() not yet implemented');
    }
}
