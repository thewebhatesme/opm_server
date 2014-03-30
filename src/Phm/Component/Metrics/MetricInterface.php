<?php
/**
 * Declares the MetricInterface class.
 *
 * @author     Mike Lohmann <mike.lohmann@deck36.de>
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