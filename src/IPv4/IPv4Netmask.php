<?php

declare(strict_types=1);

namespace NorseBlue\NetworkAddresses\IPv4;

use NorseBlue\NetworkAddresses\Concerns\HasValidationAttributes;
use NorseBlue\NetworkAddresses\IPv4\Contracts\IPv4Netmask as IPv4NetmaskContract;
use NorseBlue\NetworkAddresses\Validation\AttributeValidators\IntegerBetween;
use NorseBlue\NetworkAddresses\Validation\AttributeValidators\NetmaskInteger;
use UnexpectedValueException;

final readonly class IPv4Netmask implements IPv4NetmaskContract
{
    use HasValidationAttributes;

    public int $bits;

    public function __construct(
        #[NetmaskInteger]
        public int $netmask1,
        #[NetmaskInteger]
        public int $netmask2 = 0,
        #[NetmaskInteger]
        public int $netmask3 = 0,
        #[NetmaskInteger]
        public int $netmask4 = 0
    ) {
        $this->validateAttributes();
        $this->validateOctetJumps([$netmask1, $netmask2, $netmask3, $netmask4]);

        $this->bits = 32 - (int) log(
            ((
                ($netmask1 << 24)
                + ($netmask2 << 16)
                + ($netmask3 << 8)
                + $this->netmask4
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
     * Builds a IPv4 netmask using the given octets.
     */
    public static function build(int|array $netmask1, int $netmask2 = 0, int $netmask3 = 0, int $netmask4 = 0): self
    {
        return match (is_array($netmask1)) {
            true => self::parse(implode('.', array_pad($netmask1, 4, 0))),
            false => self::parse("$netmask1.$netmask2.$netmask3.$netmask4"),
        };
    }

    /**
     * Parses an IPv4 formatted netmask.
     *
     * Only the following formats are supported:
     * 1) Traditional: <netmask1>.<netmask2>.<netmask3>.<netmask4>
     * 2) CIDR: {optional:/}<cidr>
     *
     * @param  string  $netmask When an empty string, the netmask 255.255.255.255 is assumed
     */
    public static function parse(string $netmask): self
    {
        $netmask = trim($netmask);
        if ($netmask === '') {
            return self::fromBits(32);
        }

        if (! preg_match(IPv4Regex::NETMASK, $netmask, $raw_matches)) {
            throw new UnexpectedValueException("The given netmask '$netmask' has not a valid format.");
        }
        $filtered_matches = array_filter($raw_matches, fn ($key) => in_array($key, array_merge(IPv4Regex::NETMASK_CAPTURING_GROUPS, [IPv4Regex::CIDR_CAPTURING_GROUP]), true), ARRAY_FILTER_USE_KEY);
        $netmask_values = array_map(fn ($value) => (int) $value, $filtered_matches);

        return match (isset($netmask_values[IPv4Regex::CIDR_CAPTURING_GROUP])) {
            true => self::fromBits($netmask_values[IPv4Regex::CIDR_CAPTURING_GROUP]),
            false => new self(...$netmask_values),
        };
    }

    /**
     * @return array{
     *     netmask1: int,
     *     netmask2: int,
     *     netmask3: int,
     *     netmask4: int,
     * }
     */
    public function octets(string $key_prefix = 'netmask'): array
    {
        return [
            "{$key_prefix}1" => $this->netmask1,
            "{$key_prefix}2" => $this->netmask2,
            "{$key_prefix}3" => $this->netmask3,
            "{$key_prefix}4" => $this->netmask4,
        ];
    }

    /**
     * @param  array<int>  $netmask
     */
    private function validateOctetJumps(array $netmask): void
    {
        for ($i = 3; $i > 0; $i--) {
            if ($netmask[$i] !== 0) {
                for ($j = 0; $j < $i; $j++) {
                    if ($netmask[$j] !== 255) {
                        throw new UnexpectedValueException(
                            'The given netmask is invalid. Skipped bit found between netmask'.($j + 1).' and netmask'.($i + 1).'.'
                        );
                    }
                }
                break;
            }
        }
    }
}
