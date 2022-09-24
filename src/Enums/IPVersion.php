<?php

declare(strict_types=1);

namespace NorseBlue\NetworkAddresses\Enums;

enum IPVersion: string
{
    case IPv4 = 'ipv4';
    case IPv6 = 'ipv6';

    public function number(): int
    {
        return match ($this) {
            self::IPv4 => 4,
            self::IPv6 => 6,
        };
    }
}
