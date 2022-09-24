<?php

declare(strict_types=1);

namespace NorseBlue\NetworkAddresses\IPv4;

use NorseBlue\NetworkAddresses\Concerns\HasValidationAttributes;
use NorseBlue\NetworkAddresses\IPv4\Contracts\IPv4Netmask as IPv4NetmaskContract;
use NorseBlue\NetworkAddresses\Validation\AttributeValidators\IntegerBetween;
use NorseBlue\NetworkAddresses\Validation\AttributeValidators\NetmaskInteger;
use UnexpectedValueException;

final class IPv4Netmask implements IPv4NetmaskContract
{
    use HasValidationAttributes;

    /**
     * @var string The capturing regex for netmask that supports the following formats:
     *  1) Traditional: "<octet1>.<octet2>.<octet3>.<octet4>"
     *  2) CIDR: "{optional:/}<netmask_bits>"
     */
    public const REGEX = "%^(?:(?:(?<octet1>0|128|192|224|240|248|252|254|255)\.(?<octet2>0|128|192|224|240|248|252|254|255)\.(?<octet3>0|128|192|224|240|248|252|254|255)\.(?<octet4>0|128|192|224|240|248|252|254|255))|\/?(?<netmask_bits>[1-2]?\d|3[0-2]))$%";

    public readonly int $bits;

    public function __construct(
        #[NetmaskInteger]
        public int $octet1,
        #[NetmaskInteger]
        public int $octet2 = 0,
        #[NetmaskInteger]
        public int $octet3 = 0,
        #[NetmaskInteger]
        public int $octet4 = 0
    ) {
        $this->validateAttributes();
        $this->validateOctetJumps();

        $this->bits = 32 - (int) log(
                ((
                        ($octet1 << 24)
                        + ($octet2 << 16)
                        + ($octet3 << 8)
                        + $this->octet4
                    ) ^ 0xFFFFFFFF) + 1,
                2
            );
    }

    public static function fromBits(int $bits): self
    {
        $result = (new IntegerBetween(0, 32))->validate($bits);
        if (! $result->isValid) {
            throw new UnexpectedValueException((string) $result->message);
        }

        $netmask = 0xFFFFFFFF << (32 - $bits) & 0xFFFFFFFF;

        return new self(
            ($netmask >> 24) & 0xFF,
            ($netmask >> 16) & 0xFF,
            ($netmask >> 8) & 0xFF,
            $netmask & 0xFF
        );
    }

    /**
     * Parses an IPv4 formatted netmask.
     *
     * Only the following formats are supported:
     * 1) Traditional: <octet1>.<octet2>.<octet3>.<octet4>
     * 2) CIDR: {optional:/}<netmask_bits>
     *
     * @param  string  $netmask When an empty string, the netmask 255.255.255.255 is assumed
     */
    public static function parse(string $netmask): self
    {
        if ($netmask === '') {
            return self::fromBits(32);
        }

        if (! preg_match(self::REGEX, $netmask, $octets)) {
            throw new UnexpectedValueException("The given netmask '$netmask' has not a valid format.");
        }

        return match (isset($octets['netmask_bits'])) {
            true => self::fromBits((int) $octets['netmask_bits']),
            false => new self(
                (int) $octets['octet1'],
                (int) $octets['octet2'],
                (int) $octets['octet3'],
                (int) $octets['octet4']
            ),
        };
    }

    /**
     * @return array{
     *     octet1: int,
     *     octet2: int,
     *     octet3: int,
     *     octet4: int,
     * }
     */
    public function groups(): array
    {
        return [
            'octet1' => $this->octet1,
            'octet2' => $this->octet2,
            'octet3' => $this->octet3,
            'octet4' => $this->octet4,
        ];
    }

    private function validateOctetJumps(): void
    {
        for ($i = 4; $i > 1; $i--) {
            if ($this->{"octet$i"} !== 0) {
                for ($j = 1; $j < $i; $j++) {
                    if ($this->{"octet$j"} !== 255) {
                        throw new UnexpectedValueException(
                            "The given netmask is invalid. Skipped bit found between octet $j and $i."
                        );
                    }
                }
                break;
            }
        }
    }
}
