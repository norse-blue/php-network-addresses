<?php

declare(strict_types=1);

namespace NorseBlue\NetworkAddresses\IPv4\Contracts\Netmask;

use NorseBlue\NetworkAddresses\IPv4\Contracts\IPv4Netmask;

interface IPv4NetmaskParseable
{
    public static function parse(string $netmask): IPv4Netmask;
}
