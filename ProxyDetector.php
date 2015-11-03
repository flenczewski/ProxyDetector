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
     * Potential hostname string
     * @var array
     */
    public $proxyHostnameString = ['proxy'];

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

    /**
     * Ip setter
     *
     * @param string $ip - IP address to verify
     * @return mixed
     */
    public function setIp($ip) {

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
        return $this->_ip;
    }

    /**
     * Check IP address
     *
     * @return bool
     */
    public function isProxy()
    {
        $result = false;

        try {
            $this->checkHostname();
            // @todo: TOR exit nodes
            // @todo: proxy lists
        } catch (\Exception $e) {
            $this->messages[] = $e->getMessage();
            $result = true;
        }

        return $result;
    }


    /**
     * Check proxy string in hostname
     *
     * @param null $hostname
     * @param array|null $proxyString
     * @throws Exception
     */
    public function checkHostname($hostname = null, array $proxyString = null) {

        if(null === $hostname) {
            $hostname = gethostbyaddr($this->getIp());
        }

        if(null === $proxyString) {
            $proxyString = $this->proxyHostnameString;
        }

        foreach($proxyString as $proxyString) {
            if( false !== strripos($hostname, $proxyString) ) {
                throw new \Exception('Proxy founded. Hostname: '. $hostname);
            }
        }
    }


}