<?php
/**
 * Declares the MetricFactoryFactoryInterface class.
 *
 * @author     Mike Lohmann <mike.lohmann@deck36.de>
 * @copyright  Copyright (c) 2014 DECK36 GmbH & Co. KG (http://www.deck36.de)
 */

namespace Phm\Component\Metrics;


use Phm\Component\Metrics\Exceptions\HttpMetricFactoryNotAvailableException;

interface MetricFactoryFactoryInterface
{
    /**
     * @param string $name
     *
     * @return MetricFactoryInterface
     * @throws HttpMetricFactoryNotAvailableException
     */
    public function createMetricFactory($name);

    /**
     * @param string $name
     *
     * @return boolean
     */
    public function hasMetricFactory($name);
}