<?php

namespace NorseBlue\NetworkAddresses\IPv4\Contracts\Netmask;

use NorseBlue\NetworkAddresses\IPv4\IPv4Netmask;
use NorseBlue\NetworkAddresses\Contracts\Formatter;

interface IPv4NetmaskFormatter extends Formatter
{
    public static function using(IPv4Netmask $netmask): self;
}
