<?php
/**
 * Declares the MetricFactoryFactory class.
 *
 * @author     Mike Lohmann <mike.lohmann@deck36.de>
 * @copyright  Copyright (c) 2014 DECK36 GmbH & Co. KG (http://www.deck36.de)
 */

namespace Phm\Component\Metrics;


use Phm\Component\Metrics\Exceptions\HttpMetricFactoryNotAvailableException;

class MetricFactoryFactory implements MetricFactoryFactoryInterface
{
    /**
     * @var array
     */
    private $availableMetricFactories = array();

    public function __construct($availableMetricFactories)
    {
        $this->availableMetricFactories = $availableMetricFactories;
    }

    /**
     * {@inheritDoc}
     */
    public function createMetricFactory($name)
    {
        if (!$this->hasMetricFactory((string) $name)) {
            throw new HttpMetricFactoryNotAvailableException('The metric factory: ' . $name . ' does not exist.');
        }

        return new $this->availableMetricFactories[$name];
    }

    /**
     * {@inheritDoc}
     */
    public function hasMetricFactory($name)
    {
        return array_key_exists($name, $this->availableMetricFactories);
    }
}