<?php
/**
 * Declares the ClientItem class.
 *
 * @author     Mike Lohmann <mike.lohmann@deck36.de>
 * @copyright  Copyright (c) 2014 DECK36 GmbH & Co. KG (http://www.deck36.de)
 */

namespace Phm\Component\Storage\Items;


interface ClientItemInterface extends StorageItemInterface {
    /**
     * @const string
     */
    const NAME = 'client';

    /**
     * @param Int $duration
     */
    public function setDuration($duration);

    /**
     * @return Int
     */
    public function getDuration();

    /**
     * @param String $version
     *
     * @return ClientItemInterface
     */
    public function setVersion($version);

    /**
     * @return String
     */
    public function getVersion();

    /**
     * Set client_uuid
     *
     * @param guid $clientId
     * @return ClientItemInterface
     */
    public function setClientId($clientId);

    /**
     * Get client_uuid
     *
     * @return guid
     */
    public function getClientId();

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return ClientItemInterface
     */
    public function setCreated($created);

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated();

    /**
     * Set lastactivity
     *
     * @param \DateTime $lastactivity
     * @return ClientItemInterface
     */
    public function setLastactivity(\DateTime $lastactivity);

    /**
     * Get lastactivity
     *
     * @return \DateTime
     */
    public function getLastactivity();

    /**
     * @param MeasurementItemInterface $measurement
     */
    public function setMeasurement(MeasurementItemInterface $measurement);

    /**
     * @return MeasurementItemInterface
     */
    public function getMeasurement();

    /**
     * @param string $client_uuid
     */
    public function setClientUuid($client_uuid);

    /**
     * @return string
     */
    public function getClientUuid();
}