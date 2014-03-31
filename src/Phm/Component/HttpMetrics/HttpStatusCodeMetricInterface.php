<?php
/**
 * Declares the HttpMetricInterface class.
 *
 * @author     Mike Lohmann <mike.lohmann@deck36.de>
 */

namespace Phm\Component\HttpMetrics;


interface HttpMetricInterface
{
    /**
     * @const string
     */
    const COUNTXMLNODENAME = 'count';

    /**
     * @return int
     */
    public function getCount();
}