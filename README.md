# ProxyDetector

* Analyze hostname for "proxy" string :)
* Analyze proxy lists file

@TODO:
* Tor exit nodes
* Import proxy lists

```php
<?php
include_once 'ProxyDetector.php';
$pd = new \ProxyDetector\ProxyDetector('164.125.38.115');
if($pd->isProxy()) {
    // you use proxy
} else {
    // normal IPS
}
```
