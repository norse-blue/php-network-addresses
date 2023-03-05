<?php

declare(strict_types=1);

namespace NorseBlue\NetworkAddresses\IPv4\Formatters\Address;

use NorseBlue\NetworkAddresses\IPv4\Contracts\Address\IPv4AddressFormatter;
use NorseBlue\NetworkAddresses\IPv4\Enums\IPv4Format;
use NorseBlue\NetworkAddresses\IPv4\IPv4Address;

readonly class IPv4AddressTraditionalFormatter implements IPv4AddressFormatter
{
    private function __construct(public IPv4Address $ip_address)
    {
    }

    public function format(): string
    {
        return "{$this->ip_address->octet1}.{$this->ip_address->octet2}.{$this->ip_address->octet3}.{$this->ip_address->octet4} " . $this->ip_address->netmask->format(IPv4Format::Traditional);
    }

    public static function using(IPv4Address $ip_address): IPv4AddressFormatter
    {
        return new self($ip_address);
    }
}
