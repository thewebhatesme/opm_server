<?php
/**
 * Declares the StorageItemInterface class.
 *
 * @author     Mike Lohmann <mike.lohmann@phplabs.de>
 */

namespace Phm\Component\Storage\Items;


interface StorageItemInterface {
    /**
     * @return string
     */
    public function getName();

    /**
     * @return int
     */
    public function getId();
}