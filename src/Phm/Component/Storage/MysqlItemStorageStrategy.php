<?php
/**
 * Declares the MysqlItemStorageStrategy class.
 *
 * @author     Mike Lohmann <mike.lohmann@phplabs.de>
 */

namespace Phm\Component\Storage;


use Doctrine\ORM\EntityManager;
use Phm\Component\Storage\Exceptions\StorageStrategyException;
use Phm\Component\Storage\Items\ClientItemInterface;
use Phm\Component\Storage\Items\MeasurementItemInterface;
use Phm\Component\Storage\Items\StorageItemInterface;


class MysqlItemStorageStrategy implements StorageStrategyInterface {

    /**
     * @var array
     */
    private $registeredItems = array();

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var Validator
     */
    private $validator;

    /**
     * @param EntityManager $em
     * @param array         $items
     */
    public function __construct(EntityManager $em, array $items = array())
    {
        $this->registeredItems = $items;
        $this->em = $em;
    }

    /**
     * {@inheritDoc}
     */
    public function createItem($name)
    {
        if (!$this->hasItem($name)) {
            throw new StorageStrategyException('Item: ' . $name . ' is not registered.');
        }

        return new $this->registeredItems[$name];
    }

    /**
     * {@inheritDoc}
     */
    public function createClientItem()
    {
        return $this->createItem(ClientItemInterface::NAME);
    }

    /**
     * {@inheritDoc}
     */
    public function createMeasurementItem()
    {
        return $this->createItem(MeasurementItemInterface::NAME);
    }

    /**
     * {@inheritDoc}
     */
    public function hasItem($name)
    {
        return array_key_exists($name, $this->registeredItems);
    }

    /**
     * {@inheritDoc}
     */
    public function storeItems(array $items)
    {
        if ($this->validator->isValid($items)) {

        }

        $this->em->getConnection()->beginTransaction();
        try {
            foreach( $items as $item ) {
                $this->em->persist($item);
            }
            $this->em->flush();
            $this->em->getConnection()->commit();
        } catch (\Exception $e) {
            $this->em->getConnection()->rollback();
            throw new StorageStrategyException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function addItem(StorageItemInterface $item)
    {
        $this->registeredItems[$item->getName()] = $item;
    }
}