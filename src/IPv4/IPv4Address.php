<?php

declare(strict_types=1);

namespace NorseBlue\NetworkAddresses\IPv4;

use NorseBlue\NetworkAddresses\Concerns\HasValidationAttributes;
use NorseBlue\NetworkAddresses\IPv4\Contracts\IPv4Address as IPv4AddressContract;
use NorseBlue\NetworkAddresses\Validation\AttributeValidators\IntegerBetween;
use UnexpectedValueException;

final readonly class IPv4Address implements IPv4AddressContract
{
    use HasValidationAttributes;

    private function __construct(
        #[IntegerBetween(0, 255)]
        public int $octet1,
        #[IntegerBetween(0, 255)]
        public int $octet2,
        #[IntegerBetween(0, 255)]
        public int $octet3,
        #[IntegerBetween(0, 255)]
        public int $octet4,
        public IPv4Netmask $netmask = new IPv4Netmask(255, 255, 255, 255),
    ) {
    }

    public static function build(int|array $octet1, int $octet2 = null, int $octet3 = null, int $octet4 = null, int $netmask1 = 255, int $netmask2 = 255, int $netmask3 = 255, int $netmask4 = 255): self
    {
        if (is_array($octet1) && (count($octet1) !== 0 && count($octet1) !== 4 && count($octet1) < 8)) {
            throw new UnexpectedValueException('The given array must contain 0, 4 or 8 elements describing the octets for the IP address and the netmask.');
        }

        return match (is_int($octet1)) {
            is_null($octet2) => throw new UnexpectedValueException('The value of $octet2 cannot be null.'),
            is_null($octet3) => throw new UnexpectedValueException('The value of $octet3 cannot be null.'),
            is_null($octet4) => throw new UnexpectedValueException('The value of $octet4 cannot be null.'),
            default => match (is_array($octet1)) {
                true => self::parse(implode('.', array_pad(array_slice($octet1, 0, 4, true), 4, 0)).' '
                    .implode('.', array_pad(array_slice($octet1, 4, 4, true), 4, 255))
                ),
                false => self::parse("$octet1.$octet2.$octet3.$octet4 $netmask1.$netmask2.$netmask3.$netmask4"),
            }
        };
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
    public static function parse(string $address, ?string $netmask = null): self
    {
        $address = trim($address);

        if (! preg_match(IPv4Regex::ADDRESS, $address, $raw_matches)) {
            throw new UnexpectedValueException("IP address '$address' is not valid.");
        }
        $filtered_matches = array_filter($raw_matches, fn ($key) => in_array($key, array_merge(IPv4Regex::ADDRESS_CAPTURING_GROUPS, [IPv4Regex::NETMASK_CAPTURING_GROUP]), true), ARRAY_FILTER_USE_KEY);
        $address_values = array_map(function ($value, $key) {
            return match ($key === IPv4Regex::NETMASK_CAPTURING_GROUP) {
                false => (int) $value,
                true => IPv4Netmask::parse($value),
            };
        }, $filtered_matches, array_keys($filtered_matches));

        return new self(...array_merge($address_values));
    }

    /**
     * @return array{
     *     octet1: int,
     *     octet2: int,
     *     octet3: int,
     *     octet4: int,
     * }
     */
    public function octets(string $key_prefix = 'octet'): array
    {
        return [
            "{$key_prefix}1" => $this->octet1,
            "{$key_prefix}2" => $this->octet2,
            "{$key_prefix}3" => $this->octet3,
            "{$key_prefix}4" => $this->octet4,
        ];
    }
}
