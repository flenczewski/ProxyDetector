# ProxyDetector

* Analyze proxy lists file

@TODO:
* Tor exit nodes
* Import proxy lists (proxy, tor)

```php
<?php
include_once 'ProxyDetector.php';

$pd = new \ProxyDetector\ProxyDetector();
if($pd->isProxy('164.125.38.115')) {
    // you use proxy
} else {
    // normal ISP
}
```
