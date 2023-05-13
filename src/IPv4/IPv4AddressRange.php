<?php

declare(strict_types=1);

namespace NorseBlue\NetworkAddresses\IPv4;

use JsonSerializable;
use NorseBlue\NetworkAddresses\Exceptions\IPv4\InvalidIPv4AddressRangeException;
use NorseBlue\NetworkAddresses\IPv4\Contracts\IPv4AddressRange as IPv4AddressRangeContract;

final readonly class IPv4AddressRange implements IPv4AddressRangeContract, JsonSerializable
{
    public IPv4Address $start_address;

    public IPv4Address $end_address;

    private function __construct(IPv4Address $start_address, IPv4Address $end_address)
    {
        $this->start_address = IPv4Address::parse($start_address->format(options: ['exclude-netmask' => true]));
        $this->end_address = IPv4Address::parse($end_address->format(options: ['exclude-netmask' => true]));

        $this->validateRange($this->start_address, $this->end_address);
    }

    /**
     * Builds an IPv4 address range.
     *
     * When both addresses are given, their netmask will be ignored and a 32 bit netmask will be assumed.
     * When only a start address is given, its netmask will be used to calculate the range.
     */
    public static function build(string|IPv4Address $start_address, string|IPv4Address|null $end_address = null): self
    {
        $start_address = is_string($start_address) ? IPv4Address::parse($start_address) : $start_address;

        if ($end_address === null) {
            $end_address = $start_address->broadcastAddress();
            $start_address = $start_address->networkAddress();
        } else {
            $end_address = is_string($end_address) ? IPv4Address::parse($end_address) : $end_address;
        }

        return new self($start_address, $end_address);
    }

    private function validateRange(IPv4Address $start_address, IPv4Address $end_address): void
    {
        if ($start_address->compare($end_address) > 0) {
            throw new InvalidIPv4AddressRangeException($start_address, $end_address);
        }
    }

    public function jsonSerialize(): mixed
    {
        return [
            'start_address' => $this->start_address->format(),
            'end_address' => $this->end_address->format(),
        ];
    }
}
