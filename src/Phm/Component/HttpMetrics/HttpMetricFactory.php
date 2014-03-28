<?php
/**
 * Declares the HttpMetricFactory class.
 *
 * @author     Mike Lohmann <mike.lohmann@deck36.de>
 * @copyright  Copyright (c) 2014 DECK36 GmbH & Co. KG (http://www.deck36.de)
 */

namespace Phm\Component\HttpMetrics;


use Phm\Component\HttpMetrics\Exceptions\HttpMetricNotAvailableException;
use Phm\Component\Metrics\MetricFactoryInterface;

class HttpMetricFactory implements HttpMetricFactoryInterface, MetricFactoryInterface
{
    /**
     * Name of this factory to be used in the xml to map
     *
     * @const string
     */
    const NAME = 'http';

    /**
     * @var array
     */
    private $availableHttpMetrics = array();

    public function __construct($availableHttpMetrics)
    {
        $this->availableHttpMetrics = $availableHttpMetrics;
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return self::NAME;
    }

    /**
     * {@inheritDoc}
     */
    public function createMetric($name)
    {
        if (!$this->hasMetric((string) $name)) {
            throw new HttpMetricNotAvailableException('The metric: ' . $name . ' does not exist.');
        }

        return new $this->availableHttpMetrics[$name];
    }

    /**
     * {@inheritDoc}
     */
    public function hasMetric($name)
    {
        return array_key_exists($name, $this->availableHttpMetrics);
    }
}