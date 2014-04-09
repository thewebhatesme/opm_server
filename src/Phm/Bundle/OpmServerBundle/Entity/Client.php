<?php

namespace Phm\Bundle\OpmServerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Phm\Component\Storage\Items\ClientItemInterface;
use Phm\Component\Storage\Items\MeasurementItemInterface;

/**
 * @ORM\Table(name="clients")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
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
    const XMLVERSIONNODENAME = 'version';

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
     * @var string
     *
     * @ORM\Column(name="client_uuid", type="guid")
     */
    private $client_uuid;

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
     * @ORM\Column(name="duration", type="integer")
     */
    private $duration;

    /**
     * @var \String
     *
     * @ORM\Column(name="version", type="string", length=10)
     */
    private $version;

    /**
     * ORM\OneToOne(targetEntity="Measurement", mappedBy="client",cascade={"all"})
     * @ORM\OneToOne(targetEntity="Measurement", inversedBy="client", cascade={"all"})
     * @ORM\JoinColumn(name="measurement_id", referencedColumnName="id")
     */
    protected $measurement;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->measurements = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * {@inheritDoc}
     */
    public function setClientUuid($client_uuid)
    {
        $this->client_uuid = $client_uuid;
    }

    /**
     * {@inheritDoc}
     */
    public function getClientUuid()
    {
        return $this->client_uuid;
    }

    /**
     * {@inheritDoc}
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    /**
     * {@inheritDoc}
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * {@inheritDoc}
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * {@inheritDoc}
     */
    public function setMeasurement(MeasurementItemInterface $measurement)
    {
        $this->measurement = $measurement;
    }

    /**
     * {@inheritDoc}
     */
    public function getMeasurement()
    {
        return $this->measurement;
    }

    /**
     * {@inheritDoc}
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritDoc}
     */
    public function setClientId($clientId)
    {
        $this->client_uuid = $clientId;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getClientId()
    {
        return $this->client_uuid;
    }

    /**
     * {@inheritDoc}
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * {@inheritDoc}
     */
    public function setLastactivity(\DateTime $lastactivity)
    {
        $this->lastactivity = $lastactivity;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getLastactivity()
    {
        return $this->lastactivity;
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return self::NAME;
    }

    /**
     *  @ORM\PrePersist
     */
    public function prePersistCallback()
    {
        $this->created = new \DateTime('now');
    }
}
