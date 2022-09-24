<?php

declare(strict_types=1);

namespace NorseBlue\NetworkAddresses\IPv4;

use NorseBlue\NetworkAddresses\Concerns\HasValidationAttributes;
use NorseBlue\NetworkAddresses\IPv4\Enums\IPv4Format;
use NorseBlue\NetworkAddresses\IPv4\Enums\IPv4Notation;
use UnexpectedValueException;

class OLDIPv4Address
{
    use HasValidationAttributes;

    protected function __construct(
        public readonly IPv4Address $address,
        public readonly OLD_IPv4SubnetMask $subnet_mask = new OLD_IPv4SubnetMask(255, 255, 255, 255),
    ) {
    }

    /**
     * @param int|array{int, int, int, int, OLD_IPv4SubnetMask} $octet1
     * @param  int  $octet2
     * @param  int  $octet3
     * @param  int  $octet4
     * @param  OLD_IPv4SubnetMask  $subnet_mask
     * @return OLDIPv4Address
     */
    public static function fromOctets(
        int|array $octet1,
        int $octet2 = 0,
        int $octet3 = 0,
        int $octet4 = 0,
        OLD_IPv4SubnetMask $subnet_mask = new OLD_IPv4SubnetMask(255, 255, 255, 255)
    ): self {
        if (is_array($octet1)) {
            return new self(...$octet1);
        }

        return new self($octet1, $octet2, $octet3, $octet4, $subnet_mask);
    }

    public static function parse(string $address, ?string $subnet_mask = null): self
    {
        if ($subnet_mask === null) {
            if (! preg_match(IPv4Regex::ADDRESS, $address, $matches)) {
                throw new UnexpectedValueException("IP address $address is not valid.");
            }

            return new self(
                (int) $matches['octet1'],
                (int) $matches['octet2'],
                (int) $matches['octet3'],
                (int) $matches['octet4'],
                (isset($matches['subnet_mask']) ? OLD_IPv4SubnetMask::fromBits(
                    (int) $matches['subnet_mask']
                ) : new OLD_IPv4SubnetMask(255, 255, 255, 255))
            );
        }

        if (filter_var($address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) === false) {
            throw new UnexpectedValueException("IP address $address is not valid.");
        }

        $octets = explode('.', $subnet_mask);

        return new self(
            (int) $octets[0],
            (int) $octets[1],
            (int) $octets[2],
            (int) $octets[3],
            OLD_IPv4SubnetMask::parse($subnet_mask)
        );
    }

    public function __toString(): string
    {
        return $this->format();
    }

    public function format(
        IPv4Format $format = IPv4Format::Decimal,
        IPv4Notation $notation = IPv4Notation::Traditional
    ): string {
        return (new IPv4Formatter($format, $notation))->format($this);
    }
}
