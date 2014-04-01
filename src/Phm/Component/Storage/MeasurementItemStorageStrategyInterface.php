<?php
/**
 * Declares the MeasurementItemStorageStrategyInterface class.
 *
 * @author     Mike Lohmann <mike.lohmann@phmlabs.de>
 */
namespace Phm\Component\Storage;


use Phm\Component\Storage\Exceptions\StorageStrategyException;
use Phm\Component\Storage\Items\MeasurementItemInterface;


interface MeasurementItemStorageStrategyInterface {
    /**
     * @return MeasurementItemInterface
     *
     * @throws StorageStrategyException
     */
    public function createMeasurementItem();
}