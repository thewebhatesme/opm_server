<?php
/**
 * Declares the MetricFactoryFactoryInterface class.
 *
 * @author     Mike Lohmann <mike.lohmann@phmlabs.de>
 * @copyright  Copyright (c) 2014 DECK36 GmbH & Co. KG (http://www.deck36.de)
 */

namespace Phm\Component\Metrics;


use Phm\Component\Metrics\Exceptions\MetricFactoryNotAvailableException;

interface MetricFactoryFactoryInterface
{
    /**
     * @param string $name
     *
     * @return MetricFactoryInterface
     * @throws MetricFactoryNotAvailableException
     */
    public function createMetricFactory($name);

    /**
     * @param string $name
     *
     * @return boolean
     */
    public function hasMetricFactory($name);
}