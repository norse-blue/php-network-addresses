<?php

declare(strict_types=1);

namespace NorseBlue\NetworkAddresses\IPv4\Formatters\Address;

use NorseBlue\NetworkAddresses\IPv4\Contracts\IPv4Number;
use NorseBlue\NetworkAddresses\IPv4\Contracts\Netmask\IPv4NetmaskFormatter;

class IPv4CidrNetmaskFormatter implements IPv4NetmaskFormatter
{
    public function __construct()
    {
    }

    public function format(IPv4Number $value): string
    {
        // TODO: Implement format() method.
    }
}
