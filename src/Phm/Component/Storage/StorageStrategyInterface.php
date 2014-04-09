<?php
/**
 * Declares the StorageStrategyInterface class.
 *
 * @author     Mike Lohmann <mike.lohmann@phmlabs.de>
 */

namespace Phm\Component\Storage;


use Phm\Component\Storage\Exceptions\StorageStrategyException;
use Phm\Component\Storage\Items\StorageItemInterface;

interface StorageStrategyInterface extends ClientItemStorageStrategyInterface,
  MeasurementItemStorageStrategyInterface {
    /**
     * @param string $name
     *
     * @return StorageItemInterface
     */
    public function createItem($name);

    /**
     * @param string $name
     *
     * @return boolean
     */
    public function hasItem($name);

    /**
     * @param StorageItemInterface[]
     *
     * @return void
     *
     * @throws StorageStrategyException
     */
    public function storeItems(array $items);

    /**
     * @param StorageItemInterface $item
     *
     * @return void
     */
    public function addItem(StorageItemInterface $item);

}