<?php
/**
 * Declares the MetricInterface class.
 *
 * @author     Mike Lohmann <mike.lohmann@phmlabs.de>
 */

namespace Phm\Component\Metrics;


interface MetricInterface extends \Serializable
{
    /**
     * @param $data
     *
     * @return mixed
     */
    public function setData($data);

    /**
     * @return string
     */
    public function getName();
}