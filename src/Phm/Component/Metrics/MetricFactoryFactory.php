<?php
/**
 * Declares the MetricFactoryFactory class.
 *
 * @author     Mike Lohmann <mike.lohmann@phmlabs.de>
 * @copyright  Copyright (c) 2014 DECK36 GmbH & Co. KG (http://www.deck36.de)
 */

namespace Phm\Component\Metrics;


use Phm\Component\Metrics\Exceptions\MetricFactoryNotAvailableException;

class MetricFactoryFactory implements MetricFactoryFactoryInterface
{
    /**
     * @var array
     */
    private $availableMetricFactories = array();

    /**
     * @var array
     */
    private $createdMetricFactories = array();

    /**
     * @param array $availableMetricFactories
     */
    public function __construct(array $availableMetricFactories = array())
    {
        $this->availableMetricFactories = $availableMetricFactories;
    }

    /**
     * {@inheritDoc}
     */
    public function createMetricFactory($name)
    {
        if (!$this->hasMetricFactory((string) $name)) {
            throw new MetricFactoryNotAvailableException('The metric factory: ' . $name . ' does not exist.');
        }

        if (!isset($this->createdMetricFactories[$name])) {
            $this->createdMetricFactories[$name] = new $this->availableMetricFactories[$name];
        }

        return $this->createdMetricFactories[$name];
    }

    /**
     * {@inheritDoc}
     */
    public function hasMetricFactory($name)
    {
        return array_key_exists($name, $this->availableMetricFactories);
    }
}