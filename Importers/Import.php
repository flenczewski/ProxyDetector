<?php
/**
 * Created by PhpStorm.
 * User: fabian.lenczewski
 * Date: 2015-11-10
 * Time: 00:05
 */
namespace ProxyDetector;

abstract class Import
{
    // get new ip list
    abstract protected function update($url);

    protected function _save($file, $ipList)
    {
        // sort
        // unify and unique
        // and save
    }

    protected function _getUrl($url)
    {
        // by curl
    }


}