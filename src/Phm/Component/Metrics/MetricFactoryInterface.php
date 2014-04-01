<?php
/**
 * Declares the MetricFactoryInterface class.
 *
 * @author     Mike Lohmann <mike.lohmann@phmlabs.de>
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

    /**
     * creates metric of a given name
     *
     * @param string $name
     *
     * @return MetricInterface
     */
    public function createMetric($name);

    /**
     * @param string $name
     *
     * @return Boolean
     */
    public function hasMetric($name);
}