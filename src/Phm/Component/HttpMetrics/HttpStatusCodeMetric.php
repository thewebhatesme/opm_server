<?php
/**
 * Declares the HttpStatusCodeMetric class.
 *
 * @author  Mike Lohmann <mike.lohmann@deck36.de>
 */
namespace Phm\Component\HttpMetrics;


class HttpStatusCodeMetric implements HttpMetricInterface, HttpStatusCodeMetricInterface
{
    /**
     * @var int
     */
    private $count;

    /**
     * {@inheritDoc}
     */
    public function setCount($count)
    {
        $this->count = $count;
    }

    /**
     * {@inheritDoc}
     */
    public function getCount()
    {
        return $this->count;
    }
}