<?php
include_once '../ProxyDetector.php';
/**
 * Created by PhpStorm.
 * User: fabian.lenczewski
 * Date: 2015-11-02
 * Time: 23:01
 */

class ProxyDetectorTest extends \PHPUnit_Framework_TestCase
{
    public function providerIpOk()
    {
        return array(
            array('127.0.0.1'),
            array('192.168.0.1')
        );
    }

    public function providerIpErr()
    {
        return array(
            array('127.0.0'),
            array('127.0.0.1.'),
            array('test'),
            array('')
        );
    }
    public function providerHostnameProxyOk()
    {
        return array(
            array('proxy.org')
        );
    }

    /**
     * @dataProvider providerIpOk
     */
    public function testSetIpOk1($ip)
    {
        $pd = new \ProxyDetector\ProxyDetector($ip);
        $this->assertEquals( $pd->getIp(), $ip  );
    }

    /**
     * @dataProvider providerIpOk
     */
    public function testSetIpOk2($ip)
    {
        $pd = new \ProxyDetector\ProxyDetector();
        $pd->setIp($ip);

        $this->assertEquals( $pd->getIp(), $ip  );
    }

    /**
     * @dataProvider providerIpErr
     * @expectedException \InvalidArgumentException
     */
    public function testSetIpErr1($ip)
    {
        $pd = new \ProxyDetector\ProxyDetector($ip);
    }

    /**
     * @dataProvider providerIpErr
     * @expectedException \InvalidArgumentException
     */
    public function testSetIpErr2($ip)
    {
        $pd = new \ProxyDetector\ProxyDetector();
        $pd->setIp($ip);
    }

    /**
     * @dataProvider providerHostnameProxyOk
     */
    public function testCheckHostnameOk($hostname)
    {
        $pd = new \ProxyDetector\ProxyDetector();
        $pd->checkHostname($hostname);
        $this->assertEquals(count($pd->getMessageList()), 1);
    }

    public function testCheckProxyListOk()
    {
        $pd = new \ProxyDetector\ProxyDetector('164.125.38.115');
        $pd->checkProxyList();
        $this->assertEquals(count($pd->getMessageList()), 1);
    }

    public function testIsProxyOk()
    {
        $pd = new \ProxyDetector\ProxyDetector('164.125.38.115');
        $result = $pd->isProxy();

        $this->assertTrue($result);
    }


}
