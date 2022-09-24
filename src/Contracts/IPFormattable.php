<?php

declare(strict_types=1);

namespace NorseBlue\NetworkAddresses\Contracts;

use NorseBlue\NetworkAddresses\IPv4\Contracts\Netmask\IPv4NetmaskFormatter;

interface IPFormattable
{
    public function format(IPv4NetmaskFormatter $formatter = null): string;
}
