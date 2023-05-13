<?php

declare(strict_types=1);

namespace NorseBlue\NetworkAddresses\IPv4\Formatters\Address;

use NorseBlue\NetworkAddresses\IPv4\Contracts\Address\IPv4AddressFormatter;
use NorseBlue\NetworkAddresses\IPv4\Enums\IPv4Format;
use NorseBlue\NetworkAddresses\IPv4\IPv4Address;

readonly class IPv4AddressCidrFormatter implements IPv4AddressFormatter
{
    /**
     * @param  array<string, mixed>  $options
     */
    private function __construct(public IPv4Address $ip_address, public array $options)
    {
    }

    public function format(): string
    {
        $str = "{$this->ip_address->octet1}.{$this->ip_address->octet2}.{$this->ip_address->octet3}.{$this->ip_address->octet4}";

        if (! isset($this->options['exclude-netmask']) || $this->options['exclude-netmask'] !== true) {
            $str .= $this->ip_address->netmask->format(IPv4Format::Cidr);
        }

        return $str;
    }

    public static function using(IPv4Address $ip_address, array $options = []): IPv4AddressFormatter
    {
        return new self($ip_address, $options);
    }
}
