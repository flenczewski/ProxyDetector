# ProxyDetector 

Proxy Detector / Proxy Detection

* Analyze proxy list file
* Analyze Tor exit nodes list

@TODO:
* Import proxy lists (proxy, tor)

```php
<?php
include_once 'ProxyDetector.php';

$pd = new \ProxyDetector\Detector();
if($pd->isProxy('164.125.38.115')) {
    // you use proxy
} else {
    // normal ISP
}
```
