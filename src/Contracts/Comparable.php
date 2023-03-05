<?php

namespace NorseBlue\NetworkAddresses\Contracts;

interface Comparable
{
    /**
     * @return int Returns -1 when less than $something, 1 when greater than $something and 0 when equal to $something.
     */
    public function compare(mixed $something): int;

    public function equals(mixed $something): bool;
}
