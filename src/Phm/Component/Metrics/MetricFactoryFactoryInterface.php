<?php
/**
 * Declares the MetricFactoryFactoryInterface class.
 *
 * @author     Mike Lohmann <mike.lohmann@phmlabs.de>
 */

namespace Phm\Component\Metrics;


use Phm\Component\Metrics\Exceptions\MetricFactoryNotAvailableException;

interface MetricFactoryFactoryInterface
{

    /**
     * @param MetricFactoryInterface $metricFactory
     *
     * @return void
     */
    public function addMetricFactory(MetricFactoryInterface $metricFactory);

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