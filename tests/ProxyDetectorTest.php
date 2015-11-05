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

    /**
     * @dataProvider providerIpOk
     */
    public function testSetIpOk($ip)
    {
        $pd = new \ProxyDetector\ProxyDetector();
        $pd->setIp($ip);

        $this->assertEquals( $pd->getIp(), $ip  );
    }

    /**
     * @dataProvider providerIpErr
     * @expectedException \InvalidArgumentException
     */
    public function testSetIpErr($ip)
    {
        $pd = new \ProxyDetector\ProxyDetector();
        $pd->setIp($ip);
    }

    public function testCheckProxyListOk()
    {
        $pd = new \ProxyDetector\ProxyDetector();
        $pd->setIp('164.125.38.115');
        $pd->checkProxyList();
        $this->assertEquals(count($pd->getMessageList()), 1);
    }

    public function testIsProxyOk()
    {
        $pd = new \ProxyDetector\ProxyDetector();
        $result = $pd->isProxy('164.125.38.115');

        $this->assertTrue($result);
    }


}
