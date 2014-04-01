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
     * Get id
     *
     * @return integer
     */
    public function getId();

    /**
     * Set clientId
     *
     * @param guid $clientId
     * @return ClientItemInterface
     */
    public function setClientId($clientId);

    /**
     * Get clientId
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
}