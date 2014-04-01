<?php
/**
 * Declares the HttpMetricFactoryInterface class.
 *
 * @author     Mike Lohmann <mike.lohmann@phmlabs.de>
 */

namespace Phm\Component\HttpMetrics;


interface HttpMetricFactoryInterface
{
    /**
     * creates metric of a given name
     *
     * @param string $name
     *
     * @return HttpMetricInterface
     */
    public function createMetric($name);

    /**
     * @param string $name
     *
     * @return Boolean
     */
    public function hasMetric($name);
}