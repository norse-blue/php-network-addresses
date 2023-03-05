<?php

namespace NorseBlue\NetworkAddresses\Contracts;

interface OctetExportable
{
    /** @return array<string, int> */
    public function octets(string $prefix = 'octet'): array;
}
