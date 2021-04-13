<?php

declare(strict_types=1);

use NorseBlue\NetworkAddresses\Exceptions\ValidationException;
use NorseBlue\NetworkAddresses\IPSubnetMask\IPv4SubnetMask;

test('creates an IPv4SubnetMask from bits', function () {
    $subnet_mask = IPv4SubnetMask::fromBits(0);
    expect($subnet_mask)->toBeInstanceOf(IPv4SubnetMask::class);
    expect($subnet_mask->octet1)->toBe(0);
    expect($subnet_mask->octet2)->toBe(0);
    expect($subnet_mask->octet3)->toBe(0);
    expect($subnet_mask->octet4)->toBe(0);
    expect($subnet_mask->bits)->toBe(0);

    $subnet_mask = IPv4SubnetMask::fromBits(8);
    expect($subnet_mask)->toBeInstanceOf(IPv4SubnetMask::class);
    expect($subnet_mask->octet1)->toBe(255);
    expect($subnet_mask->octet2)->toBe(0);
    expect($subnet_mask->octet3)->toBe(0);
    expect($subnet_mask->octet4)->toBe(0);
    expect($subnet_mask->bits)->toBe(8);

    $subnet_mask = IPv4SubnetMask::fromBits(16);
    expect($subnet_mask)->toBeInstanceOf(IPv4SubnetMask::class);
    expect($subnet_mask->octet1)->toBe(255);
    expect($subnet_mask->octet2)->toBe(255);
    expect($subnet_mask->octet3)->toBe(0);
    expect($subnet_mask->octet4)->toBe(0);
    expect($subnet_mask->bits)->toBe(16);

    $subnet_mask = IPv4SubnetMask::fromBits(24);
    expect($subnet_mask)->toBeInstanceOf(IPv4SubnetMask::class);
    expect($subnet_mask->octet1)->toBe(255);
    expect($subnet_mask->octet2)->toBe(255);
    expect($subnet_mask->octet3)->toBe(255);
    expect($subnet_mask->octet4)->toBe(0);
    expect($subnet_mask->bits)->toBe(24);

    $subnet_mask = IPv4SubnetMask::fromBits(32);
    expect($subnet_mask)->toBeInstanceOf(IPv4SubnetMask::class);
    expect($subnet_mask->octet1)->toBe(255);
    expect($subnet_mask->octet2)->toBe(255);
    expect($subnet_mask->octet3)->toBe(255);
    expect($subnet_mask->octet4)->toBe(255);
    expect($subnet_mask->bits)->toBe(32);
});

it('throws an exception when bits value is less than 0', function () {
    expect(IPv4SubnetMask::fromBits(-1));
})->throws(UnexpectedValueException::class, 'Value should be greater than or equal to 0.');

it('throws an exception when bits value is greater than 32', function () {
    expect(IPv4SubnetMask::fromBits(33));
})->throws(UnexpectedValueException::class, 'Value should be less than or equal to 32.');

test('creates an IPv4SubnetMask from string', function () {
    $subnet_mask = IPv4SubnetMask::parse('0.0.0.0');
    expect($subnet_mask)->toBeInstanceOf(IPv4SubnetMask::class);
    expect($subnet_mask->octet1)->toBe(0);
    expect($subnet_mask->octet2)->toBe(0);
    expect($subnet_mask->octet3)->toBe(0);
    expect($subnet_mask->octet4)->toBe(0);
    expect($subnet_mask->bits)->toBe(0);

    $subnet_mask = IPv4SubnetMask::parse('255.0.0.0');
    expect($subnet_mask->octet1)->toBe(255);
    expect($subnet_mask->octet2)->toBe(0);
    expect($subnet_mask->octet3)->toBe(0);
    expect($subnet_mask->octet4)->toBe(0);
    expect($subnet_mask->bits)->toBe(8);

    $subnet_mask = IPv4SubnetMask::parse('255.255.0.0');
    expect($subnet_mask->octet1)->toBe(255);
    expect($subnet_mask->octet2)->toBe(255);
    expect($subnet_mask->octet3)->toBe(0);
    expect($subnet_mask->octet4)->toBe(0);
    expect($subnet_mask->bits)->toBe(16);

    $subnet_mask = IPv4SubnetMask::parse('255.255.255.0');
    expect($subnet_mask->octet1)->toBe(255);
    expect($subnet_mask->octet2)->toBe(255);
    expect($subnet_mask->octet3)->toBe(255);
    expect($subnet_mask->octet4)->toBe(0);
    expect($subnet_mask->bits)->toBe(24);

    $subnet_mask = IPv4SubnetMask::parse('255.255.255.255');
    expect($subnet_mask->octet1)->toBe(255);
    expect($subnet_mask->octet2)->toBe(255);
    expect($subnet_mask->octet3)->toBe(255);
    expect($subnet_mask->octet4)->toBe(255);
    expect($subnet_mask->bits)->toBe(32);
});

it('throws an exception when subnet mask octet1 greater than the max value', function () {
    expect(IPv4SubnetMask::parse('256.0.0.0'));
})->throws(UnexpectedValueException::class, 'Subnet mask 256.0.0.0 is not valid.');

it('throws an exception when subnet mask octet2 greater than the max value', function () {
    expect(IPv4SubnetMask::parse('255.256.0.0'));
})->throws(UnexpectedValueException::class, 'Subnet mask 255.256.0.0 is not valid.');

it('throws an exception when subnet mask octet3 greater than the max value', function () {
    expect(IPv4SubnetMask::parse('255.255.256.0'));
})->throws(UnexpectedValueException::class, 'Subnet mask 255.255.256.0 is not valid.');

it('throws an exception when subnet mask octet4 greater than the max value', function () {
    expect(IPv4SubnetMask::parse('255.255.255.256'));
})->throws(UnexpectedValueException::class, 'Subnet mask 255.255.255.256 is not valid.');

test('creates an IPv4SubnetMask from int octets', function () {
    expect(IPv4SubnetMask::fromOctets(255))->toBeInstanceOf(IPv4SubnetMask::class);
    expect(IPv4SubnetMask::fromOctets(255, 255))->toBeInstanceOf(IPv4SubnetMask::class);
    expect(IPv4SubnetMask::fromOctets(255, 255, 255))->toBeInstanceOf(IPv4SubnetMask::class);
    expect(IPv4SubnetMask::fromOctets(255, 255, 255, 192))->toBeInstanceOf(IPv4SubnetMask::class);
    expect(IPv4SubnetMask::fromOctets(255, 255, 255, 255))->toBeInstanceOf(IPv4SubnetMask::class);
});

test('creates an IPv4SubnetMask from array octets', function () {
    expect(IPv4SubnetMask::fromOctets([255]))->toBeInstanceOf(IPv4SubnetMask::class);
    expect(IPv4SubnetMask::fromOctets([255, 255]))->toBeInstanceOf(IPv4SubnetMask::class);
    expect(IPv4SubnetMask::fromOctets([255, 255, 255]))->toBeInstanceOf(IPv4SubnetMask::class);
    expect(IPv4SubnetMask::fromOctets([255, 255, 255, 192]))->toBeInstanceOf(IPv4SubnetMask::class);
    expect(IPv4SubnetMask::fromOctets([255, 255, 255, 255]))->toBeInstanceOf(IPv4SubnetMask::class);
});

it('gets the subnet mask as a decimal string', function () {
    expect((string) IPv4SubnetMask::fromBits(0))->toBe('0.0.0.0');
    expect((string) IPv4SubnetMask::fromBits(8))->toBe('255.0.0.0');
    expect((string) IPv4SubnetMask::fromBits(16))->toBe('255.255.0.0');
    expect((string) IPv4SubnetMask::fromBits(24))->toBe('255.255.255.0');
    expect((string) IPv4SubnetMask::fromBits(32))->toBe('255.255.255.255');
});

it('gets the subnet mask formatted as binary string', function () {
    expect(IPv4SubnetMask::fromBits(0)->format('bin'))->toBe('00000000.00000000.00000000.00000000');
    expect(IPv4SubnetMask::fromBits(8)->format('bin'))->toBe('11111111.00000000.00000000.00000000');
    expect(IPv4SubnetMask::fromBits(16)->format('bin'))->toBe('11111111.11111111.00000000.00000000');
    expect(IPv4SubnetMask::fromBits(24)->format('bin'))->toBe('11111111.11111111.11111111.00000000');
    expect(IPv4SubnetMask::fromBits(32)->format('bin'))->toBe('11111111.11111111.11111111.11111111');
});

it('gets the subnet mask formatted as octal string', function () {
    expect(IPv4SubnetMask::fromBits(0)->format('octal'))->toBe('0000.0000.0000.0000');
    expect(IPv4SubnetMask::fromBits(8)->format('octal'))->toBe('0377.0000.0000.0000');
    expect(IPv4SubnetMask::fromBits(16)->format('octal'))->toBe('0377.0377.0000.0000');
    expect(IPv4SubnetMask::fromBits(24)->format('octal'))->toBe('0377.0377.0377.0000');
    expect(IPv4SubnetMask::fromBits(32)->format('octal'))->toBe('0377.0377.0377.0377');
});

it('gets the subnet mask formatted as hex string', function () {
    expect(IPv4SubnetMask::fromBits(0)->format('hex'))->toBe('00.00.00.00');
    expect(IPv4SubnetMask::fromBits(8)->format('hex'))->toBe('ff.00.00.00');
    expect(IPv4SubnetMask::fromBits(16)->format('hex'))->toBe('ff.ff.00.00');
    expect(IPv4SubnetMask::fromBits(24)->format('hex'))->toBe('ff.ff.ff.00');
    expect(IPv4SubnetMask::fromBits(32)->format('hex'))->toBe('ff.ff.ff.ff');
});

it('throws an exception when subnet mask has a skipped bit in octet1', function () {
    expect(IPv4SubnetMask::parse('247.0.0.0'));
})->throws(ValidationException::class, '`NorseBlue\NetworkAddresses\IPSubnetMask\IPv4SubnetMask->octet1`: Value `247` is not a valid mask octet number.');

it('throws an exception when subnet mask has a skipped bit in octet2', function () {
    expect(IPv4SubnetMask::parse('255.247.0.0'));
})->throws(ValidationException::class, '`NorseBlue\NetworkAddresses\IPSubnetMask\IPv4SubnetMask->octet2`: Value `247` is not a valid mask octet number.');

it('throws an exception when subnet mask has a skipped bit in octet3', function () {
    expect(IPv4SubnetMask::parse('255.255.247.0'));
})->throws(ValidationException::class, '`NorseBlue\NetworkAddresses\IPSubnetMask\IPv4SubnetMask->octet3`: Value `247` is not a valid mask octet number.');

it('throws an exception when subnet mask has a skipped bit in octet4', function () {
    expect(IPv4SubnetMask::parse('255.255.255.247'));
})->throws(ValidationException::class, '`NorseBlue\NetworkAddresses\IPSubnetMask\IPv4SubnetMask->octet4`: Value `247` is not a valid mask octet number.');

it('throws an exception when subnet mask has a skipped bit between octet1 and octet2', function () {
    expect(IPv4SubnetMask::parse('254.128.0.0'));
})->throws(UnexpectedValueException::class, 'Subnet mask is invalid. Skipped bit found between octet 1 and 2.');

it('throws an exception when subnet mask has a skipped bit between octet2 and octet3', function () {
    expect(IPv4SubnetMask::parse('255.254.128.0'));
})->throws(UnexpectedValueException::class, 'Subnet mask is invalid. Skipped bit found between octet 2 and 3.');

it('throws an exception when subnet mask has a skipped bit between octet3 and octet4', function () {
    expect(IPv4SubnetMask::parse('255.255.254.128'));
})->throws(UnexpectedValueException::class, 'Subnet mask is invalid. Skipped bit found between octet 3 and 4.');
