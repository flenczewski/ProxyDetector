<?php
/**
 * Created by PhpStorm.
 * User: fabian.lenczewski
 * Date: 2015-11-02
 * Time: 22:47
 */
namespace ProxyDetector;

class Detector
{
    /**
     * IP address to verify (normal and hex)
     * @var null
     */
    private $_ip, $_ipHex = null;

    /**
     * Message list from checker
     * @var array
     */
    private $_message = [];

    const CODE_PROXYLIST = 1;
    const CODE_TOR       = 2;

    const SEPARATOR = 'o';

    /**
     * ProxyDetector constructor.
     */
    public function __construct()
    {
    }

    /**
     * Ip setter
     *
     * @param string $ip - IP address to verify
     * @return mixed
     */
    public function setIp($ip)
    {
        if(!filter_var($ip, FILTER_VALIDATE_IP)) {
            throw new \InvalidArgumentException('This is not a valid IP address ('. $ip .').');
        }

        return $this->_ip = $ip;
    }

    /**
     * Get Ip address
     *
     * @return string
     */
    public function getIp()
    {
        if(!$this->_ip) {
            throw new \InvalidArgumentException('Set the IP address first.');
        }

        return $this->_ip;
    }

    /**
     * Get encoded IP address (hex with separators)
     *
     * @return string
     */
    public function getIpHex()
    {
        $parts = explode('.', $this->getIp());

        $this->_ipHex = null;
        for ($i = 0; $i < 4; $i++) {
            $this->_ipHex .= str_pad(dechex($parts[$i]), 2, '0', STR_PAD_LEFT);
        }

        return static::SEPARATOR . $this->_ipHex . static::SEPARATOR;
    }

    /**
     * setter for checker message
     *
     * @param int $code - method code (hostname, proxylist, tor)
     * @param string $message -
     */
    private function _setMessage($code, $message)
    {
        $this->_message[$code] = $message;
    }

    /**
     * Get all messages
     *
     * @return array message list
     */
    public function getMessageList()
    {
        return $this->_message;
    }

    /**
     * Check IP address
     *
     * @param string $ip - IP address to verify
     * @return bool
     */
    public function isProxy($ip = null)
    {
        if(null !== $ip) {
            $this->setIp($ip);
        }

        $this->checkProxyList();
        $this->checkTorExitNode();

        return count($this->_message) > 0;
    }


    /**
     * Search ip address in proxy list file
     */
    public function checkProxyList()
    {
        $proxyString = file_get_contents(__DIR__ .'/data/proxy-list.txt', FILE_USE_INCLUDE_PATH);

        if(strpos($proxyString, $this->getIpHex())) {
            $this->_setMessage(static::CODE_PROXYLIST, 'Proxy founded in proxy list: '. $this->getIp());
        }
    }

    /**
     * Search ip address in tor exit nodes
     */
    public function checkTorExitNode()
    {
        $proxyString = file_get_contents(__DIR__ .'/data/tor-ip.txt', FILE_USE_INCLUDE_PATH);

        if(strpos($proxyString, $this->getIpHex())) {
            $this->_setMessage(static::CODE_TOR, 'Proxy founded in tor exit nodes list: '. $this->getIp());
        }
    }

}