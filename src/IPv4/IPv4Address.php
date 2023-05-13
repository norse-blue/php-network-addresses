<?php

declare(strict_types=1);

namespace NorseBlue\NetworkAddresses\IPv4;

use Exception;
use NorseBlue\NetworkAddresses\Concerns\HasValidationAttributes;
use NorseBlue\NetworkAddresses\IPv4\Contracts\IPv4Address as IPv4AddressContract;
use NorseBlue\NetworkAddresses\IPv4\Enums\IPv4Format;
use NorseBlue\NetworkAddresses\IPv4\Formatters\Address\IPv4AddressBinaryFormatter;
use NorseBlue\NetworkAddresses\IPv4\Formatters\Address\IPv4AddressCidrFormatter;
use NorseBlue\NetworkAddresses\IPv4\Formatters\Address\IPv4AddressTraditionalFormatter;
use NorseBlue\NetworkAddresses\Validation\AttributeValidators\IntegerBetween;
use RuntimeException;
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

    /**
     * @param  int|array<int>  $octet1 When an empty array is given, the ip address 0.0.0.0/32 will be assumed.
     * When an incomplete array is given it will be completed with 0 values for the missing ip address octets. The
     *     missing values for the netmask follow the same rules as {@see IPv4Netmask::build}.
     */
    public static function build(int|array $octet1, int $octet2 = null, int $octet3 = null, int $octet4 = null, int $netmask1 = 255, int $netmask2 = 255, int $netmask3 = 255, int $netmask4 = 255): self
    {
        if (is_array($octet1) && (count($octet1) !== 0 && count($octet1) !== 4 && count($octet1) < 8)) {
            throw new UnexpectedValueException('The given array must contain 0, 4 or 8 elements describing the octets for the IPv4 address and the IPv4 netmask.');
        }

        return match (is_int($octet1)) {
            is_null($octet2) => throw new UnexpectedValueException('The value of $octet2 cannot be null.'),
            is_null($octet3) => throw new UnexpectedValueException('The value of $octet3 cannot be null.'),
            is_null($octet4) => throw new UnexpectedValueException('The value of $octet4 cannot be null.'),
            default => match (is_array($octet1)) {
                true => self::parse(
                    address: implode('.', array_pad(array_slice($octet1, 0, 4), 4, 0)),
                    netmask: IPv4Netmask::build(array_slice($octet1, 4, 4)),
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
     * @param  string  $address Can include the netmask or just the address part. When an empty string is given the ip
     *     address 0.0.0.0/32 will be assumed.
     * @param  string|array<int>|IPv4Netmask|null  $netmask When specified, this value will take precedence.
     */
    public static function parse(string $address, string|array|IPv4Netmask|null $netmask = null): self
    {
        $address = trim($address);
        if ($address === '') {
            return new self(0, 0, 0, 0);
        }

        if (! preg_match(IPv4Regex::ADDRESS, $address, $raw_matches)) {
            throw new UnexpectedValueException("IPv4 address '$address' is not valid.");
        }

        $filtered_matches = array_filter($raw_matches, fn ($key) => in_array($key, array_merge(IPv4Regex::ADDRESS_CAPTURING_GROUPS, [IPv4Regex::NETMASK_CAPTURING_GROUP]), true), ARRAY_FILTER_USE_KEY);
        foreach (range(1, 4) as $octet) {
            $address_values["octet$octet"] = (int) $filtered_matches["octet$octet"];
        }
        $netmask_value = $netmask === null ? IPv4Netmask::parse($filtered_matches[IPv4Regex::NETMASK_CAPTURING_GROUP] ?? '') : match (true) {
            is_string($netmask) => IPv4Netmask::parse($netmask),
            is_array($netmask) => IPv4Netmask::build($netmask),
            default => $netmask,
        };

        return new self($address_values['octet1'], $address_values['octet2'], $address_values['octet3'], $address_values['octet4'], $netmask_value);
    }

    /**
     * @return array<string, int>
     */
    public function octets(string $prefix = 'octet'): array
    {
        return [
            "{$prefix}1" => $this->octet1,
            "{$prefix}2" => $this->octet2,
            "{$prefix}3" => $this->octet3,
            "{$prefix}4" => $this->octet4,
        ];
    }

    /**
     * @return int Returns -1 when less than $something, 1 when greater than $something and 0 when equal to $something.
     *     In this case, if it comes to netmask comparison, the comparison result would be inverted, because an IP
     *     Address with a netmask with fewer bits would be more 'general' regarding sub-netting.
     */
    public function compare(mixed $something): int
    {
        if (! is_string($something) && ! is_array($something) && ! $something instanceof IPv4Address) {
            throw new RuntimeException('Type IPv4Address and type `'.gettype($something).'` are not comparable.');
        }

        try {
            $compareTo = match (true) {
                is_string($something) => self::parse($something),
                is_array($something) => self::build($something),
                default => $something,
            };
        } catch (Exception $exception) {
            throw new RuntimeException('The value of $something is not a valid IPv4 address to compare to.', previous: $exception);
        }

        foreach (range(1, 4) as $octet) {
            $comparison = $this->{"octet$octet"} <=> $compareTo->{"octet$octet"};

            if ($comparison !== 0) {
                return $comparison;
            }
        }

        return -1 * $this->netmask->compare($compareTo->netmask);
    }

    public function equals(mixed $something): bool
    {
        return $this->compare($something) === 0;
    }

    /**
     * @param  array<string, mixed>  $options
     */
    public function format(IPv4Format $format = IPv4Format::Cidr, array $options = []): string
    {
        $formatter = match ($format) {
            IPv4Format::Binary => IPv4AddressBinaryFormatter::using($this, $options),
            IPv4Format::Cidr => IPv4AddressCidrFormatter::using($this, $options),
            IPv4Format::Traditional => IPv4AddressTraditionalFormatter::using($this, $options),
        };

        return $formatter->format();
    }

    public function __toString(): string
    {
        return $this->format();
    }

    public function networkAddress(): self
    {
        $network = long2ip(
            ip2long($this->format(options: ['exclude-netmask' => true]))
            & ip2long($this->netmask->format(IPv4Format::Traditional))
        );

        if ($network === false) {
            throw new RuntimeException();
        }

        return IPv4Address::parse($network);
    }

    public function broadcastAddress(): self
    {
        $network = $this->networkAddress();
        $broadcast = long2ip(
            ip2long($network->format(options: ['exclude-netmask' => true]))
            + pow(2, (32 - $this->netmask->bits)) - 1
        );

        if ($broadcast === false) {
            throw new RuntimeException();
        }

        return IPv4Address::parse($broadcast);
    }
}
