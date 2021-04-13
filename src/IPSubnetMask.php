<?php

declare(strict_types=1);

namespace NorseBlue\NetworkAddresses;

interface IPSubnetMask
{
    public static function parse(string $subnet_mask): self;

    public function __toString(): string;
}
