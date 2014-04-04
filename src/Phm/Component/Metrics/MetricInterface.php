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
     * @const string
     */
    const NAMEXMLNODEATTRIBUTE = "name";

    /**
     * @const string
     */
    const TYPEXMLNODEATTRIBUTE = "class";

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