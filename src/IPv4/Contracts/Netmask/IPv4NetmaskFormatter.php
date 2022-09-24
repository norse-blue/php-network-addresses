<?php

declare(strict_types=1);

namespace NorseBlue\NetworkAddresses\IPv4\Contracts\Netmask;

interface IPv4NetmaskFormatter
{
    public function format(): string;
}
