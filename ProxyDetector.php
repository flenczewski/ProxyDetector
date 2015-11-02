<?php
/**
 * Created by PhpStorm.
 * User: fabian.lenczewski
 * Date: 2015-11-02
 * Time: 22:47
 */

class ProxyDetector
{
    /**
     * IP address to verify
     * @var null
     */
    private $_ip = null;

    /**
     * ProxyDetector constructor.
     * @param string $ip - IP address to verify
     */
    public function __construct($ip = null)
    {
        if(null !== $ip) {
            $this->setIp($ip);
        }
    }

    public function setIp($ip) {

        if(!filter_var($ip, FILTER_VALIDATE_IP)) {
            throw new InvalidArgumentException('This is not a valid IP address ('. $ip .').');
        }

        return $this->_ip = $ip;
    }

    public function getIp()
    {
        return $this->_ip;
    }

    public function isProxy()
    {
        // @todo: :)
        return false;
    }

}