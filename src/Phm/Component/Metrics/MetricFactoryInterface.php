<?php
/**
 * Declares the MetricFactoryInterface class.
 *
 * @author     Mike Lohmann <mike.lohmann@deck36.de>
 * @copyright  Copyright (c) 2014 DECK36 GmbH & Co. KG (http://www.deck36.de)
 */

namespace Phm\Component\Metrics;


interface MetricFactoryInterface
{
    /**
     * returns the name of the factory to be used within the xml mapping
     *
     * @return string
     */
    public function getName();
}