<?php
date_default_timezone_set('America/Los_Angeles');
include_once '../Detector.php';
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

    /**
     * @dataProvider providerIpOk
     */
    public function testSetIpOk($ip)
    {
        $pd = new \ProxyDetector\Detector();
        $pd->setIp($ip);

        $this->assertEquals( $pd->getIp(), $ip  );
    }

    /**
     * @dataProvider providerIpErr
     * @expectedException \InvalidArgumentException
     */
    public function testSetIpErr($ip)
    {
        $pd = new \ProxyDetector\Detector();
        $pd->setIp($ip);
    }

    public function testCheckProxyListOk()
    {
        $pd = new \ProxyDetector\Detector();
        $pd->setIp('98.142.192.236');
        $pd->checkProxyList();
        $this->assertEquals(count($pd->getMessageList()), 1);
    }

    public function testCheckTorExitNodeOk()
    {
        $pd = new \ProxyDetector\Detector();
        $pd->setIp('223.27.33.202');
        $pd->checkTorExitNode();
        $this->assertEquals(count($pd->getMessageList()), 1);
    }

    public function testIsProxyOk1()
    {
        $pd = new \ProxyDetector\Detector();
        $result = $pd->isProxy('98.142.192.236');

        $this->assertTrue($result);
    }

    public function testIsProxyOk2()
    {
        $pd = new \ProxyDetector\Detector();
        $result = $pd->isProxy('223.27.33.202');

        $this->assertTrue($result);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testIsProxyErr()
    {
        $pd = new \ProxyDetector\Detector();
        $pd->isProxy();
    }

}
