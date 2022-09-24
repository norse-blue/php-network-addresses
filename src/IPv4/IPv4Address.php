<?php

declare(strict_types=1);

namespace NorseBlue\NetworkAddresses\IPv4;

use NorseBlue\NetworkAddresses\Concerns\HasValidationAttributes;
use NorseBlue\NetworkAddresses\IPv4\Contracts\IPv4Address as IPv4AddressContract;
use NorseBlue\NetworkAddresses\Validation\AttributeValidators\IntegerBetween;
use UnexpectedValueException;

final class IPv4Address implements IPv4AddressContract
{
    use HasValidationAttributes;

    private const REGEX = '%^(?<octet1>25[0-5]|2[0-4]\d|1\d\d|[1-9]\d?|0)\.(?<octet2>25[0-5]|2[0-4]\d|1\d\d|[1-9]\d?|0)\.(?<octet3>25[0-5]|2[0-4]\d|1\d\d|[1-9]\d?|0)\.(?<octet4>25[0-5]|2[0-4]\d|1\d\d|[1-9]\d?|0)(?<netmask>(?: (?:0|128|192|224|240|248|252|254|255)(?:\.(?:0|128|192|224|240|248|252|254|255)){3})|/[1-2]?\d|3[0-2])?$%';

    private function __construct(
        #[IntegerBetween(0, 255)]
        public readonly int $octet1,
        #[IntegerBetween(0, 255)]
        public readonly int $octet2,
        #[IntegerBetween(0, 255)]
        public readonly int $octet3,
        #[IntegerBetween(0, 255)]
        public readonly int $octet4,
        public readonly IPv4Netmask $netmask = new IPv4Netmask(255, 255, 255, 255),
    ) {
    }

    /**
     * Parses an IPv4 formatted address.
     *
     * Only the following formats are supported:
     * 1) Traditional: <octet1>.<octet2>.<octet3>.<octet4>{optional <netmask1>.<netmask2>.<netmask3>.<netmask4>}
     * 2) CIDR: <octet1>.<octet2>.<octet3>.<octet4>{optional:/<netmask_bits>}
     * When a netmask is not given, 255.255.255.255 is assumed.
     *
     * @param  string  $address Can include the netmask or just the address part.
     * @param  string|null  $netmask When specified, this value will take precedence.
     */
    public static function parse(string $address, ?string $netmask = null): IPv4Address
    {
        if (! preg_match(self::REGEX, $address, $matches)) {
            throw new UnexpectedValueException("IP address $address is not valid.");
        }

        return new self(
            (int) $matches['octet1'],
            (int) $matches['octet2'],
            (int) $matches['octet3'],
            (int) $matches['octet4'],
            IPv4Netmask::parse($netmask ?? trim($matches['netmask'] ?? '')),
        );
    }

    public function groups(): array
    {
        return [
            'octet1' => $this->octet1,
            'octet2' => $this->octet2,
            'octet3' => $this->octet3,
            'octet4' => $this->octet4,
        ];
    }
}
