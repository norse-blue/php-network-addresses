<?php

namespace NorseBlue\NetworkAddresses\IPv4\Contracts\Address;

use NorseBlue\NetworkAddresses\Contracts\Formatter;
use NorseBlue\NetworkAddresses\IPv4\IPv4Address;
interface IPv4AddressFormatter extends Formatter
{
    public static function using(IPv4Address $ip_address): self;
}
