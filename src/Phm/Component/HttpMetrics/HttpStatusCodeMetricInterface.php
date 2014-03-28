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
     * @param int $count
     */
    public function setCount($count);

    /**
     * @return int
     */
    public function getCount();
}