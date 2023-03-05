<?php

namespace NorseBlue\NetworkAddresses\IPv4\Contracts\Netmask;

use NorseBlue\NetworkAddresses\Contracts\Formatter;
use NorseBlue\NetworkAddresses\IPv4\IPv4Netmask;

interface IPv4NetmaskFormatter extends Formatter
{
    public static function using(IPv4Netmask $netmask): self;
}
