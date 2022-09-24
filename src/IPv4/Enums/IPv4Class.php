<?php

declare(strict_types=1);

namespace NorseBlue\NetworkAddresses\IPv4\Enums;

use NorseBlue\NetworkAddresses\IPv4\OLDIPv4Address;

enum IPv4Class : string
{
    public const MASK_A = 0x00;

    public const MASK_B = 0x80;

    public const MASK_C = 0xC0;

    public const MASK_D = 0xE0;

    public const MASK_E = 0xF0;

    case A = 'A';
    case B = 'B';
    case C = 'C';
    case D = 'D';
    case E = 'E';

    public static function fromIPv4(string|OLDIPv4Address $ip): self
    {
        $ip = (is_string($ip)) ? OLDIPv4Address::parse($ip) : $ip;

        return match (true) {
            (($ip->octet1 & self::MASK_E) === self::MASK_E) => self::E,
            (($ip->octet1 & self::MASK_D) === self::MASK_D) => self::D,
            (($ip->octet1 & self::MASK_C) === self::MASK_C) => self::C,
            (($ip->octet1 & self::MASK_B) === self::MASK_B) => self::B,
            default => self::A,
        };
    }
}
