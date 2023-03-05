<?php

declare(strict_types=1);

namespace NorseBlue\NetworkAddresses\IPv4\Contracts;

use NorseBlue\NetworkAddresses\Contracts\OctetExportable;
use NorseBlue\NetworkAddresses\IPv4\Contracts\Netmask\IPv4NetmaskParseable;

interface IPv4Netmask extends IPv4NetmaskParseable, OctetExportable
{
}
