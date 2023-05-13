<?php

declare(strict_types=1);

namespace NorseBlue\NetworkAddresses\IPv4\Enums;

enum IPv4Format: string
{
    case Binary = 'binary';
    case Cidr = 'cidr';
    case Traditional = 'traditional';
}
