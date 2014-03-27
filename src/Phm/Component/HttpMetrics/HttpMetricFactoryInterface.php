<?php
/**
 * Declares the HttpMetricFactoryInterface class.
 *
 * @author     Mike Lohmann <mike.lohmann@deck36.de>
 */

namespace Phm\Component\HttpMetrics;


interface HttpMetricFactoryInterface
{
    public function createMetric($name = 'count2xx');
}