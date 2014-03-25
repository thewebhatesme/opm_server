<?php

namespace Phm\Bundle\OpmServerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Measurement
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Measurement
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \stdClass
     *
     * @ORM\Column(name="metrics", type="object")
     */
    private $metrics;

    /**
     * @var string
     *
     * @ORM\Column(name="rawData", type="blob")
     */
    private $rawData;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set metrics
     *
     * @param \stdClass $metrics
     * @return Measurement
     */
    public function setMetrics($metrics)
    {
        $this->metrics = $metrics;

        return $this;
    }

    /**
     * Get metrics
     *
     * @return \stdClass 
     */
    public function getMetrics()
    {
        return $this->metrics;
    }

    /**
     * Set rawData
     *
     * @param string $rawData
     * @return Measurement
     */
    public function setRawData($rawData)
    {
        $this->rawData = $rawData;

        return $this;
    }

    /**
     * Get rawData
     *
     * @return string 
     */
    public function getRawData()
    {
        return $this->rawData;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Measurement
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }
}
