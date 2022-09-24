<?php

declare(strict_types=1);

namespace NorseBlue\NetworkAddresses\IPv4;

use NorseBlue\NetworkAddresses\IPv4\Enums\IPv4Format;
use NorseBlue\NetworkAddresses\IPv4\Enums\IPv4Notation;

class IPv4Formatter
{
    public function __construct(
        public readonly IPv4Format $format = IPv4Format::Decimal,
        public readonly IPv4Notation $notation = IPv4Notation::Traditional
    ) {
    }

    public function format(OLDIPv4Address|OLD_IPv4SubnetMask $value): string
    {
        if ($this->notation === IPv4Notation::CIDR) {
            return match (true) {
                $value instanceof OLD_IPv4SubnetMask => $this->formatSubnetMaskInCIDR($value),
                $value instanceof OLDIPv4Address => $this->formatAddressInCIDR($value),
            };
        }

        return $this->formatAddressTraditional($value);
    }

    protected function formatAddressInCIDR(OLDIPv4Address $value): string
    {
        return $this->formatAddressTraditional($value).$this->formatSubnetMaskInCIDR($value->subnet_mask);
    }

    protected function formatAddressTraditional(OLDIPv4Address|OLD_IPv4SubnetMask $value): string
    {
        $octets = $value->octets();

        $octets = array_map(fn ($octet) => str_pad(
            $this->transformer($this->format)($octet),
            $this->padsize($this->format),
            '0',
            STR_PAD_LEFT
        ), $octets);

        return implode('.', $octets);
    }

    protected function formatSubnetMaskInCIDR(OLD_IPv4SubnetMask $value): string
    {
        return '/'.$value->bits;
    }

    protected function padsize(IPv4Format $format): int
    {
        return match ($format) {
            IPv4Format::Binary => 8,
            IPv4Format::Decimal => 0,
            IPv4Format::Hexadecimal => 2,
            IPv4Format::Octal => 4,
        };
    }

    protected function transformer(IPv4Format $format): callable
    {
        return match ($format) {
            IPv4Format::Binary => decbin(...),
            IPv4Format::Decimal => static fn (int $input): string => (string) $input,
            IPv4Format::Hexadecimal => dechex(...),
            IPv4Format::Octal => decoct(...),
        };
    }
}
