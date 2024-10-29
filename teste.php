<?php

require 'vendor/autoload.php';

use mercadopago\SDK;

SDK::setAccessToken('YOUR_ACCESS_TOKEN');

echo "SDK Loaded Successfully!";
