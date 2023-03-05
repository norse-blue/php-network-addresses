<?php

namespace NorseBlue\NetworkAddresses\Contracts;

use NorseBlue\NetworkAddresses\IPv4\Enums\IPv4Format;

interface Formattable
{
    public function format(IPv4Format $format = IPv4Format::Cidr): string;
}
