<?php

declare(strict_types=1);

namespace NorseBlue\NetworkAddresses\IPv4\Formatters\Netmask;

use NorseBlue\NetworkAddresses\IPv4\Contracts\IPv4Netmask;
use NorseBlue\NetworkAddresses\IPv4\Contracts\Netmask\IPv4NetmaskFormatter;

class IPv4NetmaskCidrFormatter implements IPv4NetmaskFormatter
{
    public function __construct(public readonly IPv4Netmask $netmask)
    {
    }

    public function format(): string
    {
        return "/{$this->netmask->bits}";
    }
}
