<?php
/**
 * Declares the StorageStrategyInterface class.
 *
 * @author     Mike Lohmann <mike.lohmann@phmlabs.de>
 */

namespace Phm\Component\Storage;


use Phm\Component\Storage\Exceptions\StorageStrategyException;
use Phm\Component\Storage\Items\ClientItemInterface;

interface ClientItemStorageStrategyInterface {
    /**
     * @return ClientItemInterface
     *
     * @throws StorageStrategyException
     */
    public function createClientItem();
}