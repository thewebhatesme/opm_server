<?php
/**
 * Declares the HttpMetricFactory class.
 *
 * @author     Mike Lohmann <mike.lohmann@deck36.de>
 * @copyright  Copyright (c) 2014 DECK36 GmbH & Co. KG (http://www.deck36.de)
 */

namespace Phm\Component\HttpMetrics;


class HttpMetricFactory implements HttpMetricFactoryInterface
{
    /**
     * @var array
     */
    private $availableHttpMetrics = array();

    /**
     * {@inheritDoc}
     */
    public function createMetric($name = 'count2xx')
    {
        // TODO: Implement createMetric() method.
    }
}