<?php
/**
 * Declares the HttpMetricInterface class.
 *
 * @author     Mike Lohmann <mike.lohmann@phmlabs.de>
 */

namespace Phm\Component\HttpMetrics;


interface HttpStatusCodeMetricInterface
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