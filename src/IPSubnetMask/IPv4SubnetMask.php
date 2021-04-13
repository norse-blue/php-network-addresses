<?php

declare(strict_types=1);

namespace NorseBlue\NetworkAddresses\IPSubnetMask;

use JetBrains\PhpStorm\Immutable;
use NorseBlue\NetworkAddresses\IPSubnetMask;
use NorseBlue\NetworkAddresses\Traits\HasValidationAttributes;
use NorseBlue\NetworkAddresses\Validation\Validators\IntegerBetween;
use NorseBlue\NetworkAddresses\Validation\Validators\SubnetMaskOctetNumber;
use UnexpectedValueException;

class IPv4SubnetMask implements IPSubnetMask
{
    use HasValidationAttributes;

    #[Immutable]
    public int $bits;

    protected function __construct(
        #[SubnetMaskOctetNumber]
        #[Immutable]
        public int $octet1,
        #[SubnetMaskOctetNumber]
        #[Immutable]
        public int $octet2 = 0,
        #[SubnetMaskOctetNumber]
        #[Immutable]
        public int $octet3 = 0,
        #[SubnetMaskOctetNumber]
        #[Immutable]
        public int $octet4 = 0
    ) {
        $this->validateAttributes();

        $this->bits = 32 - (int) log(((($octet1 << 24) + ($octet2 << 16) + ($octet3 << 8) + $this->octet4) ^ 0xFFFFFFFF) + 1, 2);
    }

    public static function fromBits(int $bits): self
    {
        $result = (new IntegerBetween(0, 32))->validate($bits);
        if (! $result->isValid) {
            throw new UnexpectedValueException((string) $result->message);
        }

        $mask = 0xFFFFFFFF << (32 - $bits) & 0xFFFFFFFF;

        return new self(
            ($mask >> 24) & 0xFF,
            ($mask >> 16) & 0xFF,
            ($mask >> 8) & 0xFF,
            $mask & 0xFF
        );
    }

    /**
     * @param int|int[] $octet1
     */
    public static function fromOctets(
        int|array $octet1,
        int $octet2 = 0,
        int $octet3 = 0,
        int $octet4 = 0
    ): self {
        if (is_array($octet1)) {
            return new self(...$octet1);
        }

        return new self($octet1, $octet2, $octet3, $octet4);
    }

    public static function parse(string $subnet_mask): self
    {
        if (! filter_var($subnet_mask, FILTER_VALIDATE_IP)) {
            throw new UnexpectedValueException("Subnet mask $subnet_mask is not valid.");
        }

        $octets = explode('.', $subnet_mask);

        return new self((int) $octets[0], (int) $octets[1], (int) $octets[2], (int) $octets[3]);
    }

    /**
     * @return int[]
     */
    public function octets(): array
    {
        return [
            $this->octet1,
            $this->octet2,
            $this->octet3,
            $this->octet4,
        ];
    }

    public function __toString(): string
    {
        return $this->format('decimal');
    }

    public function format(string $format): string
    {
        $octets = $this->octets();
        $formatter = match ($format) {
            'bin' => 'decbin',
            'octal' => 'decoct',
            'hex' => 'dechex',
            default => null,
        };

        if ($formatter !== null) {
            $octets = array_map(static fn ($octet) => str_pad($formatter($octet), match ($formatter) {
                'decbin' => 8,
                'decoct' => 4,
                'dechex' => 2,
            }, '0', STR_PAD_LEFT), $octets);
        }

        return implode('.', $octets);
    }
}
