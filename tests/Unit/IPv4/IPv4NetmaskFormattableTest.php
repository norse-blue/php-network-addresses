<?php

declare(strict_types=1);

use NorseBlue\NetworkAddresses\IPv4\Enums\IPv4Format;
use NorseBlue\NetworkAddresses\IPv4\IPv4Netmask;

it('gets the netmask as a decimal string when casting as string', function () {
    expect((string) IPv4Netmask::fromBits(0))->toBe('/0');
    expect((string) IPv4Netmask::fromBits(8))->toBe('/8');
    expect((string) IPv4Netmask::fromBits(16))->toBe('/16');
    expect((string) IPv4Netmask::fromBits(24))->toBe('/24');
    expect((string) IPv4Netmask::fromBits(32))->toBe('/32');
});

it('gets the netmask formatted as decimal string', function () {
    expect(IPv4Netmask::fromBits(0)->format(IPv4Format::Traditional))->toBe('0.0.0.0');
    expect(IPv4Netmask::fromBits(8)->format(IPv4Format::Traditional))->toBe('255.0.0.0');
    expect(IPv4Netmask::fromBits(16)->format(IPv4Format::Traditional))->toBe('255.255.0.0');
    expect(IPv4Netmask::fromBits(24)->format(IPv4Format::Traditional))->toBe('255.255.255.0');
    expect(IPv4Netmask::fromBits(32)->format(IPv4Format::Traditional))->toBe('255.255.255.255');
});
