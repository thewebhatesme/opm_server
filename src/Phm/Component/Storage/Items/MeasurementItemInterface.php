<?php
/**
 * Declares the ClientItem class.
 *
 * @author     Mike Lohmann <mike.lohmann@deck36.de>
 * @copyright  Copyright (c) 2014 DECK36 GmbH & Co. KG (http://www.deck36.de)
 */

namespace Phm\Component\Storage\Items;


use Phm\Component\Metrics\MetricInterface;

interface MeasurementItemInterface extends StorageItemInterface {
    /**
     * @const string
     */
    const NAME = 'measurement';

    /**
     * @param int $clientId
     */
    public function setClientUuid($clientId);

    /**
     * @return int
     */
    public function getClientUuid();

    /**
     * Set metrics
     *
     * @param array $metrics
     * @return MeasurementItemInterface
     */
    public function addMetric(MetricInterface $metric);

    /**
     * Set metrics
     *
     * @param array $metrics
     * @return MeasurementItemInterface
     */
    public function setMetrics(array $metrics);

    /**
     * Get metrics
     *
     * @return MeasurementItemInterface[]
     */
    public function getMetrics();

    /**
     * Set rawData
     *
     * @param string $rawData
     * @return MeasurementItemInterface
     */
    public function setRawData($rawData);

    /**
     * Get rawData
     *
     * @return string
     */
    public function getRawData();

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return MeasurementItemInterface
     */
    public function setCreated($created);

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated();

    /**
     * @param mixed $client
     */
    public function setClient(ClientItemInterface $client);

    /**
     * @return mixed
     */
    public function getClient();
}