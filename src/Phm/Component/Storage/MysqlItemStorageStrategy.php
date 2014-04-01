<?php
/**
 * Declares the MysqlItemStorageStrategy class.
 *
 * @author     Mike Lohmann <mike.lohmann@deck36.de>
 * @copyright  Copyright (c) 2014 DECK36 GmbH & Co. KG (http://www.deck36.de)
 */

namespace Phm\Component\Storage;


use Doctrine\ORM\EntityManager;
use Phm\Component\Storage\Exceptions\StorageStrategyException;
use Phm\Component\Storage\Items\ClientItemInterface;
use Phm\Component\Storage\Items\MeasurementItemInterface;

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
     * @param array $items
     */
    public function __construct(array $items = array(), EntityManager $em)
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
}