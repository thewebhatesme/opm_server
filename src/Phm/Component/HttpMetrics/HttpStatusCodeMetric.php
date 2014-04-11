<?php
/**
 * Declares the HttpStatusCodeMetric class.
 *
 * @author  Mike Lohmann <mike.lohmann@phplabs.de>
 */
namespace Phm\Component\HttpMetrics;


use Symfony\Component\DomCrawler\Crawler;

class HttpStatusCodeMetric implements HttpMetricInterface, HttpStatusCodeMetricInterface
{
    /**
     * @const string
     */
    const NAME = 'httpstatuscodemetric';

    /**
     * @var Crawler
     */
    private $data;

    /**
     * {@inheritDoc}
     */
    public function getCount()
    {
        return (int) $this->data->filter(self::COUNTXMLNODENAME)->text();
    }

    /**
     * {@inheritDoc}
     */
    public function setData($data)
    {
        $this->data = $data;
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
    public function serialize()
    {
        return serialize($this->data);
    }

    /**
     * {@inheritDoc}
     */
    public function unserialize($serialized)
    {
        $this->data = unserialize($serialized);
    }
}