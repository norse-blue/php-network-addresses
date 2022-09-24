<?php

declare(strict_types=1);

namespace NorseBlue\NetworkAddresses\IPv4\Contracts\Address;

use NorseBlue\NetworkAddresses\IPv4\Contracts\IPv4Address;

interface IPv4AddressParseable
{
    public static function parse(string $address, ?string $netmask = null): IPv4Address;
}
