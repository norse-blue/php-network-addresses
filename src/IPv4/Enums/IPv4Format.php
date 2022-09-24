<?php

declare(strict_types=1);

namespace NorseBlue\NetworkAddresses\IPv4\Enums;

enum IPv4Format: string
{
    case Binary = 'bin';
    case Decimal = 'dec';
    case Hexadecimal = 'hex';
    case Octal = 'octal';
}
