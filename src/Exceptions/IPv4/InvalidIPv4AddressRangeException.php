<?php

namespace NorseBlue\NetworkAddresses\Exceptions\IPv4;

use NorseBlue\NetworkAddresses\IPv4\IPv4Address;
use RuntimeException;
use Throwable;

/**
 * @codeCoverageIgnore
 */
class InvalidIPv4AddressRangeException extends RuntimeException
{
    public function __construct(
        public readonly IPv4Address $start_address,
        public readonly IPv4Address $end_address,
        ?Throwable $previous = null,
    ) {
        parent::__construct("Invalid IPv4 address range given by '{$this->start_address->format()} - {$this->end_address->format()}'.", previous: $previous);
    }
}
