<?php

declare(strict_types=1);

namespace NorseBlue\NetworkAddresses\IPv4\Formatters\Netmask;

use NorseBlue\NetworkAddresses\IPv4\Contracts\Netmask\IPv4NetmaskFormatter;
use NorseBlue\NetworkAddresses\IPv4\IPv4Netmask;

readonly class IPv4NetmaskCidrFormatter implements IPv4NetmaskFormatter
{
    private function __construct(public IPv4Netmask $netmask)
    {
    }

    public function format(): string
    {
        return "/{$this->netmask->bits}";
    }

    public static function using(IPv4Netmask $netmask): IPv4NetmaskFormatter
    {
        return new self($netmask);
    }
}
