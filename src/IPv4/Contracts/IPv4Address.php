<?php

declare(strict_types=1);

namespace NorseBlue\NetworkAddresses\IPv4\Contracts;

use NorseBlue\NetworkAddresses\IPv4\Contracts\Address\IPv4AddressParseable;

interface IPv4Address extends IPv4AddressParseable
{
    /** @return array<string, int> */
    public function octets(): array;
}
