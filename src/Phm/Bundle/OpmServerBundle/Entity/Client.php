<?php

namespace Phm\Bundle\OpmServerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Phm\Component\Storage\Items\ClientItemInterface;

/**
 * Client
 *
 * @ORM\Table()
 */
class Client implements ClientItemInterface
{
    /**
     * @const string
     */
    const XMLNODENAME = 'client';

    /**
     * @const string
     */
    const XMLDURATIONNODENAME = 'duration';

    /**
     * @const string
     */
    const XMLVERSIONNODENAME = 'verstion';

    /**
     * @const string
     */
    const XMLSTARTNODENAME = 'start';


    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var guid
     *
     * @ORM\Column(name="clientId", type="guid")
     */
    private $clientId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastactivity", type="datetime")
     */
    private $lastactivity;

    /**
     * @var \Int
     *
     * @ORM\Column(name="duration", type="int")
     */
    private $duration;

    /**
     * @var \String
     *
     * @ORM\Column(name="version", type="string")
     */
    private $version;

    /**
     * @param Int $duration
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    /**
     * @return Int
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @param String $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * @return String
     */
    public function getVersion()
    {
        return $this->version;
    }

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
     * Set clientId
     *
     * @param guid $clientId
     * @return Clients
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;

        return $this;
    }

    /**
     * Get clientId
     *
     * @return guid
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Clients
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

    /**
     * Set lastactivity
     *
     * @param \DateTime $lastactivity
     * @return Clients
     */
    public function setLastactivity($lastactivity)
    {
        $this->lastactivity = $lastactivity;

        return $this;
    }

    /**
     * Get lastactivity
     *
     * @return \DateTime
     */
    public function getLastactivity()
    {
        return $this->lastactivity;
    }
}
