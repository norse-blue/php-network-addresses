<?php

declare(strict_types=1);

namespace NorseBlue\NetworkAddresses\IPv4\Contracts;

interface IPv4Netmask
{
    /** @return array<string, int> */
    public function octets(): array;
}
