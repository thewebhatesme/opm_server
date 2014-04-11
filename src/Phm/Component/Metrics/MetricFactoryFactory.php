<?php
/**
 * Declares the MetricFactoryFactory class.
 *
 * @author     Mike Lohmann <mike.lohmann@phmlabs.de>
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
     * {@inheritDoc}
     */
    public function addMetricFactory(MetricFactoryInterface $metricFactory)
    {
        $this->availableMetricFactories[$metricFactory->getName()] = $metricFactory;
    }

    /**
     * {@inheritDoc}
     */
    public function createMetricFactory($name)
    {
        if (!$this->hasMetricFactory((string) $name)) {
            throw new MetricFactoryNotAvailableException('The metric factory: ' . $name . ' does not exist.');
        }

        return $this->availableMetricFactories[$name];
    }

    /**
     * {@inheritDoc}
     */
    public function hasMetricFactory($name)
    {
        return array_key_exists($name, $this->availableMetricFactories);
    }
}