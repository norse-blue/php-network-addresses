<?php

declare(strict_types=1);

namespace NorseBlue\NetworkAddresses\IPv4\Enums;

enum IPv4Format: string
{
    case Traditional = 'traditional';
    case Cidr = 'cidr';
}
