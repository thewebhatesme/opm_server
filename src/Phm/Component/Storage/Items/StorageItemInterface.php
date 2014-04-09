<?php
/**
 * Declares the StorageItemInterface class.
 *
 * @author     Mike Lohmann <mike.lohmann@deck36.de>
 * @copyright  Copyright (c) 2014 DECK36 GmbH & Co. KG (http://www.deck36.de)
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