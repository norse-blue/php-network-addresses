<?php

declare(strict_types=1);

use NorseBlue\NetworkAddresses\IPv4\IPv4Netmask;

test('creates an IPv4Netmask from bits', function () {
    $netmask = IPv4Netmask::fromBits(0);
    expect($netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($netmask->octet1)->toBe(0)
        ->and($netmask->octet2)->toBe(0)
        ->and($netmask->octet3)->toBe(0)
        ->and($netmask->octet4)->toBe(0)
        ->and($netmask->bits)->toBe(0);

    $netmask = IPv4Netmask::fromBits(8);
    expect($netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($netmask->octet1)->toBe(255)
        ->and($netmask->octet2)->toBe(0)
        ->and($netmask->octet3)->toBe(0)
        ->and($netmask->octet4)->toBe(0)
        ->and($netmask->bits)->toBe(8);

    $netmask = IPv4Netmask::fromBits(16);
    expect($netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($netmask->octet1)->toBe(255)
        ->and($netmask->octet2)->toBe(255)
        ->and($netmask->octet3)->toBe(0)
        ->and($netmask->octet4)->toBe(0)
        ->and($netmask->bits)->toBe(16);

    $netmask = IPv4Netmask::fromBits(24);
    expect($netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($netmask->octet1)->toBe(255)
        ->and($netmask->octet2)->toBe(255)
        ->and($netmask->octet3)->toBe(255)
        ->and($netmask->octet4)->toBe(0)
        ->and($netmask->bits)->toBe(24);

    $netmask = IPv4Netmask::fromBits(32);
    expect($netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($netmask->octet1)->toBe(255)
        ->and($netmask->octet2)->toBe(255)
        ->and($netmask->octet3)->toBe(255)
        ->and($netmask->octet4)->toBe(255)
        ->and($netmask->bits)->toBe(32);
});

it('throws an exception when bits value is less than 0', function () {
    expect(IPv4Netmask::fromBits(-1));
})->throws(UnexpectedValueException::class, 'Value `-1` has to be greater than or equal to 0.');

it('throws an exception when bits value is greater than 32', function () {
    expect(IPv4Netmask::fromBits(33));
})->throws(UnexpectedValueException::class, 'Value `33` has to be less than or equal to 32.');

test('creates an IPv4Netmask from string', function () {
    $netmask = IPv4Netmask::parse('');
    expect($netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($netmask->octet1)->toBe(255)
        ->and($netmask->octet2)->toBe(255)
        ->and($netmask->octet3)->toBe(255)
        ->and($netmask->octet4)->toBe(255)
        ->and($netmask->bits)->toBe(32);

    $netmask = IPv4Netmask::parse('0.0.0.0');
    expect($netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($netmask->octet1)->toBe(0)
        ->and($netmask->octet2)->toBe(0)
        ->and($netmask->octet3)->toBe(0)
        ->and($netmask->octet4)->toBe(0)
        ->and($netmask->bits)->toBe(0);

    $netmask = IPv4Netmask::parse('255.0.0.0');
    expect($netmask->octet1)->toBe(255)
        ->and($netmask->octet2)->toBe(0)
        ->and($netmask->octet3)->toBe(0)
        ->and($netmask->octet4)->toBe(0)
        ->and($netmask->bits)->toBe(8);

    $netmask = IPv4Netmask::parse('255.255.0.0');
    expect($netmask->octet1)->toBe(255)
        ->and($netmask->octet2)->toBe(255)
        ->and($netmask->octet3)->toBe(0)
        ->and($netmask->octet4)->toBe(0)
        ->and($netmask->bits)->toBe(16);

    $netmask = IPv4Netmask::parse('255.255.255.0');
    expect($netmask->octet1)->toBe(255)
        ->and($netmask->octet2)->toBe(255)
        ->and($netmask->octet3)->toBe(255)
        ->and($netmask->octet4)->toBe(0)
        ->and($netmask->bits)->toBe(24);

    $netmask = IPv4Netmask::parse('255.255.255.255');
    expect($netmask->octet1)->toBe(255)
        ->and($netmask->octet2)->toBe(255)
        ->and($netmask->octet3)->toBe(255)
        ->and($netmask->octet4)->toBe(255)
        ->and($netmask->bits)->toBe(32);
});

it('throws an exception when netmask octet1 greater than the max value', function () {
    expect(IPv4Netmask::parse('256.0.0.0'));
})->throws(UnexpectedValueException::class, "The given netmask '256.0.0.0' has not a valid format.");

it('throws an exception when netmask octet2 greater than the max value', function () {
    expect(IPv4Netmask::parse('255.256.0.0'));
})->throws(UnexpectedValueException::class, "The given netmask '255.256.0.0' has not a valid format.");

it('throws an exception when netmask octet3 greater than the max value', function () {
    expect(IPv4Netmask::parse('255.255.256.0'));
})->throws(UnexpectedValueException::class, "The given netmask '255.255.256.0' has not a valid format.");

it('throws an exception when netmask octet4 greater than the max value', function () {
    expect(IPv4Netmask::parse('255.255.255.256'));
})->throws(UnexpectedValueException::class, "The given netmask '255.255.255.256' has not a valid format.");

//test('creates an IPv4Netmask from int octets', function () {
//    expect(IPv4Netmask::fromOctets(255))->toBeInstanceOf(IPv4Netmask::class);
//    expect(IPv4Netmask::fromOctets(255, 255))->toBeInstanceOf(IPv4Netmask::class);
//    expect(IPv4Netmask::fromOctets(255, 255, 255))->toBeInstanceOf(IPv4Netmask::class);
//    expect(IPv4Netmask::fromOctets(255, 255, 255, 192))->toBeInstanceOf(IPv4Netmask::class);
//    expect(IPv4Netmask::fromOctets(255, 255, 255, 255))->toBeInstanceOf(IPv4Netmask::class);
//});

//test('creates an IPv4Netmask from array octets', function () {
//    expect(IPv4Netmask::fromOctets([255]))->toBeInstanceOf(IPv4Netmask::class);
//    expect(IPv4Netmask::fromOctets([255, 255]))->toBeInstanceOf(IPv4Netmask::class);
//    expect(IPv4Netmask::fromOctets([255, 255, 255]))->toBeInstanceOf(IPv4Netmask::class);
//    expect(IPv4Netmask::fromOctets([255, 255, 255, 192]))->toBeInstanceOf(IPv4Netmask::class);
//    expect(IPv4Netmask::fromOctets([255, 255, 255, 255]))->toBeInstanceOf(IPv4Netmask::class);
//});

//it('gets the netmask as a decimal string', function () {
//    expect((string) IPv4Netmask::fromBits(0))->toBe('0.0.0.0');
//    expect((string) IPv4Netmask::fromBits(8))->toBe('255.0.0.0');
//    expect((string) IPv4Netmask::fromBits(16))->toBe('255.255.0.0');
//    expect((string) IPv4Netmask::fromBits(24))->toBe('255.255.255.0');
//    expect((string) IPv4Netmask::fromBits(32))->toBe('255.255.255.255');
//});

//it('gets the netmask formatted as decimal string', function () {
//    expect(IPv4Netmask::fromBits(0)->format(IPv4Format::Decimal))->toBe('0.0.0.0');
//    expect(IPv4Netmask::fromBits(8)->format(IPv4Format::Decimal))->toBe('255.0.0.0');
//    expect(IPv4Netmask::fromBits(16)->format(IPv4Format::Decimal))->toBe('255.255.0.0');
//    expect(IPv4Netmask::fromBits(24)->format(IPv4Format::Decimal))->toBe('255.255.255.0');
//    expect(IPv4Netmask::fromBits(32)->format(IPv4Format::Decimal))->toBe('255.255.255.255');
//});

//it('gets the netmask formatted as binary string', function () {
//    expect(IPv4Netmask::fromBits(0)->format(IPv4Format::Binary))->toBe('00000000.00000000.00000000.00000000');
//    expect(IPv4Netmask::fromBits(8)->format(IPv4Format::Binary))->toBe('11111111.00000000.00000000.00000000');
//    expect(IPv4Netmask::fromBits(16)->format(IPv4Format::Binary))->toBe('11111111.11111111.00000000.00000000');
//    expect(IPv4Netmask::fromBits(24)->format(IPv4Format::Binary))->toBe('11111111.11111111.11111111.00000000');
//    expect(IPv4Netmask::fromBits(32)->format(IPv4Format::Binary))->toBe('11111111.11111111.11111111.11111111');
//});

//it('gets the netmask formatted as octal string', function () {
//    expect(IPv4Netmask::fromBits(0)->format(IPv4Format::Octal))->toBe('0000.0000.0000.0000');
//    expect(IPv4Netmask::fromBits(8)->format(IPv4Format::Octal))->toBe('0377.0000.0000.0000');
//    expect(IPv4Netmask::fromBits(16)->format(IPv4Format::Octal))->toBe('0377.0377.0000.0000');
//    expect(IPv4Netmask::fromBits(24)->format(IPv4Format::Octal))->toBe('0377.0377.0377.0000');
//    expect(IPv4Netmask::fromBits(32)->format(IPv4Format::Octal))->toBe('0377.0377.0377.0377');
//});

//it('gets the netmask formatted as hex string', function () {
//    expect(IPv4Netmask::fromBits(0)->format(IPv4Format::Hexadecimal))->toBe('00.00.00.00');
//    expect(IPv4Netmask::fromBits(8)->format(IPv4Format::Hexadecimal))->toBe('ff.00.00.00');
//    expect(IPv4Netmask::fromBits(16)->format(IPv4Format::Hexadecimal))->toBe('ff.ff.00.00');
//    expect(IPv4Netmask::fromBits(24)->format(IPv4Format::Hexadecimal))->toBe('ff.ff.ff.00');
//    expect(IPv4Netmask::fromBits(32)->format(IPv4Format::Hexadecimal))->toBe('ff.ff.ff.ff');
//});

it('throws an exception when netmask skips a bit in octet1', function () {
    expect(IPv4Netmask::parse('247.0.0.0'));
})->throws(UnexpectedValueException::class, "The given netmask '247.0.0.0' has not a valid format.");

it('throws an exception when netmask skips a bit in octet2', function () {
    expect(IPv4Netmask::parse('255.247.0.0'));
})->throws(UnexpectedValueException::class, "The given netmask '255.247.0.0' has not a valid format.");

it('throws an exception when netmask skips a bit in octet3', function () {
    expect(IPv4Netmask::parse('255.255.247.0'));
})->throws(UnexpectedValueException::class, "The given netmask '255.255.247.0' has not a valid format.");

it('throws an exception when netmask skips a bit in octet4', function () {
    expect(IPv4Netmask::parse('255.255.255.247'));
})->throws(UnexpectedValueException::class, "The given netmask '255.255.255.247' has not a valid format.");

it('throws an exception when netmask skips a bit between octet1 and octet2', function () {
    expect(IPv4Netmask::parse('254.128.0.0'));
})->throws(UnexpectedValueException::class, 'The given netmask is invalid. Skipped bit found between octet 1 and 2.');

it('throws an exception when netmask skips a bit between octet2 and octet3', function () {
    expect(IPv4Netmask::parse('255.254.128.0'));
})->throws(UnexpectedValueException::class, 'The given netmask is invalid. Skipped bit found between octet 2 and 3.');

it('throws an exception when netmask skips a bit between octet3 and octet4', function () {
    expect(IPv4Netmask::parse('255.255.254.128'));
})->throws(UnexpectedValueException::class, 'The given netmask is invalid. Skipped bit found between octet 3 and 4.');
