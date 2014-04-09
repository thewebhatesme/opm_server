<?php

namespace Phm\Bundle\OpmServerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Phm\Component\Metrics\MetricInterface;
use Phm\Component\Storage\Items\ClientItemInterface;
use Phm\Component\Storage\Items\MeasurementItemInterface;

/**
 * Measurement
 *
 * @ORM\Table(name="measurements")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Measurement implements MeasurementItemInterface
{
    /**
     *
     * @const string
     */
    const XMLNODENAME = 'measurement';

    /**
     *
     * @const string
     */
    const METRICSXMLNODENAME = 'metrics';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var array
     *
     * @ORM\Column(name="metrics", type="array")
     */
    private $metrics;

    /**
     * @var string
     *
     * @ORM\Column(name="rawData", type="blob", nullable=true)
     */
    private $rawData;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @ORM\OneToOne(targetEntity="Client", mappedBy="measurement", cascade={"all"}, fetch="LAZY")
     */
    protected $client;

    /**
     * @var string
     *
     * @ORM\Column(name="client_uuid", type="guid")
     */
    private $client_uuid;

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
    public function setClientUuid($clientUuid)
    {
        $this->client_uuid = $clientUuid;
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
    public function addMetric(MetricInterface $metric)
    {
        $this->metrics[$metric->getName()][] = $metric;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setClient(ClientItemInterface $client)
    {
        $client->setMeasurement($this);
        $this->client = $client;
    }

    /**
     * {@inheritDoc}
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * {@inheritDoc}
     */
    public function setMetrics(array $metrics)
    {
        $this->metrics = $metrics;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getMetrics()
    {
        return $this->metrics;
    }

    /**
     * {@inheritDoc}
     */
    public function setRawData($rawData)
    {
        $this->rawData = $rawData;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getRawData()
    {
        return $this->rawData;
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
