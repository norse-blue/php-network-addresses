<?php

declare(strict_types=1);

use NorseBlue\NetworkAddresses\IPv4\IPv4Netmask;

test('creates an IPv4Netmask from bits', function () {
    $netmask = IPv4Netmask::fromBits(0);
    expect($netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($netmask->netmask1)->toBe(0)
        ->and($netmask->netmask2)->toBe(0)
        ->and($netmask->netmask3)->toBe(0)
        ->and($netmask->netmask4)->toBe(0)
        ->and($netmask->bits)->toBe(0);

    $netmask = IPv4Netmask::fromBits(8);
    expect($netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($netmask->netmask1)->toBe(255)
        ->and($netmask->netmask2)->toBe(0)
        ->and($netmask->netmask3)->toBe(0)
        ->and($netmask->netmask4)->toBe(0)
        ->and($netmask->bits)->toBe(8);

    $netmask = IPv4Netmask::fromBits(16);
    expect($netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($netmask->netmask1)->toBe(255)
        ->and($netmask->netmask2)->toBe(255)
        ->and($netmask->netmask3)->toBe(0)
        ->and($netmask->netmask4)->toBe(0)
        ->and($netmask->bits)->toBe(16);

    $netmask = IPv4Netmask::fromBits(24);
    expect($netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($netmask->netmask1)->toBe(255)
        ->and($netmask->netmask2)->toBe(255)
        ->and($netmask->netmask3)->toBe(255)
        ->and($netmask->netmask4)->toBe(0)
        ->and($netmask->bits)->toBe(24);

    $netmask = IPv4Netmask::fromBits(32);
    expect($netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($netmask->netmask1)->toBe(255)
        ->and($netmask->netmask2)->toBe(255)
        ->and($netmask->netmask3)->toBe(255)
        ->and($netmask->netmask4)->toBe(255)
        ->and($netmask->bits)->toBe(32);
});

it('throws an exception when bits value is less than 0', function () {
    expect(IPv4Netmask::fromBits(-1));
})->throws(UnexpectedValueException::class, 'Value `-1` has to be greater than or equal to 0.');

it('throws an exception when bits value is greater than 32', function () {
    expect(IPv4Netmask::fromBits(33));
})->throws(UnexpectedValueException::class, 'Value `33` has to be less than or equal to 32.');

test('creates an IPv4Netmask from octet string', function () {
    $netmask = IPv4Netmask::parse('');
    expect($netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($netmask->netmask1)->toBe(255)
        ->and($netmask->netmask2)->toBe(255)
        ->and($netmask->netmask3)->toBe(255)
        ->and($netmask->netmask4)->toBe(255)
        ->and($netmask->bits)->toBe(32);

    $netmask = IPv4Netmask::parse('0.0.0.0');
    expect($netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($netmask->netmask1)->toBe(0)
        ->and($netmask->netmask2)->toBe(0)
        ->and($netmask->netmask3)->toBe(0)
        ->and($netmask->netmask4)->toBe(0)
        ->and($netmask->bits)->toBe(0);

    $netmask = IPv4Netmask::parse('255.0.0.0');
    expect($netmask->netmask1)->toBe(255)
        ->and($netmask->netmask2)->toBe(0)
        ->and($netmask->netmask3)->toBe(0)
        ->and($netmask->netmask4)->toBe(0)
        ->and($netmask->bits)->toBe(8);

    $netmask = IPv4Netmask::parse('255.255.0.0');
    expect($netmask->netmask1)->toBe(255)
        ->and($netmask->netmask2)->toBe(255)
        ->and($netmask->netmask3)->toBe(0)
        ->and($netmask->netmask4)->toBe(0)
        ->and($netmask->bits)->toBe(16);

    $netmask = IPv4Netmask::parse('255.255.255.0');
    expect($netmask->netmask1)->toBe(255)
        ->and($netmask->netmask2)->toBe(255)
        ->and($netmask->netmask3)->toBe(255)
        ->and($netmask->netmask4)->toBe(0)
        ->and($netmask->bits)->toBe(24);

    $netmask = IPv4Netmask::parse('255.255.255.255');
    expect($netmask->netmask1)->toBe(255)
        ->and($netmask->netmask2)->toBe(255)
        ->and($netmask->netmask3)->toBe(255)
        ->and($netmask->netmask4)->toBe(255)
        ->and($netmask->bits)->toBe(32);
});

test('creates an IPv4Netmask from CIDR string', function () {
    $netmask = IPv4Netmask::parse('');
    expect($netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($netmask->netmask1)->toBe(255)
        ->and($netmask->netmask2)->toBe(255)
        ->and($netmask->netmask3)->toBe(255)
        ->and($netmask->netmask4)->toBe(255)
        ->and($netmask->bits)->toBe(32);

    $netmask = IPv4Netmask::parse('/0');
    expect($netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($netmask->netmask1)->toBe(0)
        ->and($netmask->netmask2)->toBe(0)
        ->and($netmask->netmask3)->toBe(0)
        ->and($netmask->netmask4)->toBe(0)
        ->and($netmask->bits)->toBe(0);

    $netmask = IPv4Netmask::parse('/8');
    expect($netmask->netmask1)->toBe(255)
        ->and($netmask->netmask2)->toBe(0)
        ->and($netmask->netmask3)->toBe(0)
        ->and($netmask->netmask4)->toBe(0)
        ->and($netmask->bits)->toBe(8);

    $netmask = IPv4Netmask::parse('/16');
    expect($netmask->netmask1)->toBe(255)
        ->and($netmask->netmask2)->toBe(255)
        ->and($netmask->netmask3)->toBe(0)
        ->and($netmask->netmask4)->toBe(0)
        ->and($netmask->bits)->toBe(16);

    $netmask = IPv4Netmask::parse('/24');
    expect($netmask->netmask1)->toBe(255)
        ->and($netmask->netmask2)->toBe(255)
        ->and($netmask->netmask3)->toBe(255)
        ->and($netmask->netmask4)->toBe(0)
        ->and($netmask->bits)->toBe(24);

    $netmask = IPv4Netmask::parse('/32');
    expect($netmask->netmask1)->toBe(255)
        ->and($netmask->netmask2)->toBe(255)
        ->and($netmask->netmask3)->toBe(255)
        ->and($netmask->netmask4)->toBe(255)
        ->and($netmask->bits)->toBe(32);
});

test('creates an IPv4Netmask from int octets', function () {
    $netmask = IPv4Netmask::build(0);
    expect($netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($netmask->netmask1)->toBe(0)
        ->and($netmask->netmask2)->toBe(0)
        ->and($netmask->netmask3)->toBe(0)
        ->and($netmask->netmask4)->toBe(0);

    $netmask = IPv4Netmask::build(255);
    expect($netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($netmask->netmask1)->toBe(255)
        ->and($netmask->netmask2)->toBe(0)
        ->and($netmask->netmask3)->toBe(0)
        ->and($netmask->netmask4)->toBe(0);

    $netmask = IPv4Netmask::build(255, 255);
    expect($netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($netmask->netmask1)->toBe(255)
        ->and($netmask->netmask2)->toBe(255)
        ->and($netmask->netmask3)->toBe(0)
        ->and($netmask->netmask4)->toBe(0);

    $netmask = IPv4Netmask::build(255, 255, 255);
    expect($netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($netmask->netmask1)->toBe(255)
        ->and($netmask->netmask2)->toBe(255)
        ->and($netmask->netmask3)->toBe(255)
        ->and($netmask->netmask4)->toBe(0);

    $netmask = IPv4Netmask::build(255, 255, 255, 192);
    expect($netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($netmask->netmask1)->toBe(255)
        ->and($netmask->netmask2)->toBe(255)
        ->and($netmask->netmask3)->toBe(255)
        ->and($netmask->netmask4)->toBe(192);

    $netmask = IPv4Netmask::build(255, 255, 255, 255);
    expect($netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($netmask->netmask1)->toBe(255)
        ->and($netmask->netmask2)->toBe(255)
        ->and($netmask->netmask3)->toBe(255)
        ->and($netmask->netmask4)->toBe(255);
});

test('creates an IPv4Netmask from array octets', function () {
    $netmask = IPv4Netmask::build([0]);
    expect($netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($netmask->netmask1)->toBe(0)
        ->and($netmask->netmask2)->toBe(0)
        ->and($netmask->netmask3)->toBe(0)
        ->and($netmask->netmask4)->toBe(0);

    $netmask = IPv4Netmask::build([0, 0, 0, 0]);
    expect($netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($netmask->netmask1)->toBe(0)
        ->and($netmask->netmask2)->toBe(0)
        ->and($netmask->netmask3)->toBe(0)
        ->and($netmask->netmask4)->toBe(0);

    $netmask = IPv4Netmask::build([255]);
    expect($netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($netmask->netmask1)->toBe(255)
        ->and($netmask->netmask2)->toBe(0)
        ->and($netmask->netmask3)->toBe(0)
        ->and($netmask->netmask4)->toBe(0);

    $netmask = IPv4Netmask::build([255, 255]);
    expect($netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($netmask->netmask1)->toBe(255)
        ->and($netmask->netmask2)->toBe(255)
        ->and($netmask->netmask3)->toBe(0)
        ->and($netmask->netmask4)->toBe(0);

    $netmask = IPv4Netmask::build([255, 255, 255]);
    expect($netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($netmask->netmask1)->toBe(255)
        ->and($netmask->netmask2)->toBe(255)
        ->and($netmask->netmask3)->toBe(255)
        ->and($netmask->netmask4)->toBe(0);

    $netmask = IPv4Netmask::build([255, 255, 255, 192]);
    expect($netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($netmask->netmask1)->toBe(255)
        ->and($netmask->netmask2)->toBe(255)
        ->and($netmask->netmask3)->toBe(255)
        ->and($netmask->netmask4)->toBe(192);

    $netmask = IPv4Netmask::build([255, 255, 255, 255]);
    expect($netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($netmask->netmask1)->toBe(255)
        ->and($netmask->netmask2)->toBe(255)
        ->and($netmask->netmask3)->toBe(255)
        ->and($netmask->netmask4)->toBe(255);
});

it('throws an exception when netmask netmask1 greater than the max value', function () {
    expect(IPv4Netmask::parse('256.0.0.0'));
})->throws(UnexpectedValueException::class, "The given netmask '256.0.0.0' has not a valid format.");

it('throws an exception when netmask netmask2 greater than the max value', function () {
    expect(IPv4Netmask::parse('255.256.0.0'));
})->throws(UnexpectedValueException::class, "The given netmask '255.256.0.0' has not a valid format.");

it('throws an exception when netmask netmask3 greater than the max value', function () {
    expect(IPv4Netmask::parse('255.255.256.0'));
})->throws(UnexpectedValueException::class, "The given netmask '255.255.256.0' has not a valid format.");

it('throws an exception when netmask netmask4 greater than the max value', function () {
    expect(IPv4Netmask::parse('255.255.255.256'));
})->throws(UnexpectedValueException::class, "The given netmask '255.255.255.256' has not a valid format.");

test('retrieves the octets in an IPv4Netmask netmask with default prefix', function () {
    $netmask = IPv4Netmask::parse('0.0.0.0');
    expect($netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($netmask->octets())->toBe([
            'netmask1' => 0,
            'netmask2' => 0,
            'netmask3' => 0,
            'netmask4' => 0,
        ]);

    $netmask = IPv4Netmask::parse('255.0.0.0');
    expect($netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($netmask->octets())->toBe([
            'netmask1' => 255,
            'netmask2' => 0,
            'netmask3' => 0,
            'netmask4' => 0,
        ]);

    $netmask = IPv4Netmask::parse('255.255.0.0');
    expect($netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($netmask->octets())->toBe([
            'netmask1' => 255,
            'netmask2' => 255,
            'netmask3' => 0,
            'netmask4' => 0,
        ]);

    $netmask = IPv4Netmask::parse('255.255.255.0');
    expect($netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($netmask->octets())->toBe([
            'netmask1' => 255,
            'netmask2' => 255,
            'netmask3' => 255,
            'netmask4' => 0,
        ]);

    $netmask = IPv4Netmask::parse('255.255.255.255');
    expect($netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($netmask->octets())->toBe([
            'netmask1' => 255,
            'netmask2' => 255,
            'netmask3' => 255,
            'netmask4' => 255,
        ]);
});

test('retrieves the octets in an IPv4Netmask netmask with custom prefix', function () {
    $netmask = IPv4Netmask::parse('0.0.0.0');
    expect($netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($netmask->octets('octet'))->toBe([
            'octet1' => 0,
            'octet2' => 0,
            'octet3' => 0,
            'octet4' => 0,
        ]);

    $netmask = IPv4Netmask::parse('255.0.0.0');
    expect($netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($netmask->octets('octet'))->toBe([
            'octet1' => 255,
            'octet2' => 0,
            'octet3' => 0,
            'octet4' => 0,
        ]);

    $netmask = IPv4Netmask::parse('255.255.0.0');
    expect($netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($netmask->octets('octet'))->toBe([
            'octet1' => 255,
            'octet2' => 255,
            'octet3' => 0,
            'octet4' => 0,
        ]);

    $netmask = IPv4Netmask::parse('255.255.255.0');
    expect($netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($netmask->octets('octet'))->toBe([
            'octet1' => 255,
            'octet2' => 255,
            'octet3' => 255,
            'octet4' => 0,
        ]);

    $netmask = IPv4Netmask::parse('255.255.255.255');
    expect($netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($netmask->octets('octet'))->toBe([
            'octet1' => 255,
            'octet2' => 255,
            'octet3' => 255,
            'octet4' => 255,
        ]);
});

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

it('throws an exception when netmask skips a bit in netmask1', function () {
    expect(IPv4Netmask::parse('247.0.0.0'));
})->throws(UnexpectedValueException::class, "The given netmask '247.0.0.0' has not a valid format.");

it('throws an exception when netmask skips a bit in netmask2', function () {
    expect(IPv4Netmask::parse('255.247.0.0'));
})->throws(UnexpectedValueException::class, "The given netmask '255.247.0.0' has not a valid format.");

it('throws an exception when netmask skips a bit in netmask3', function () {
    expect(IPv4Netmask::parse('255.255.247.0'));
})->throws(UnexpectedValueException::class, "The given netmask '255.255.247.0' has not a valid format.");

it('throws an exception when netmask skips a bit in netmask4', function () {
    expect(IPv4Netmask::parse('255.255.255.247'));
})->throws(UnexpectedValueException::class, "The given netmask '255.255.255.247' has not a valid format.");

it('throws an exception when netmask skips a bit between netmask1 and netmask2', function () {
    expect(IPv4Netmask::parse('254.128.0.0'));
})->throws(UnexpectedValueException::class, 'The given netmask is invalid. Skipped bit found between netmask1 and netmask2.');

it('throws an exception when netmask skips a bit between netmask2 and netmask3', function () {
    expect(IPv4Netmask::parse('255.254.128.0'));
})->throws(UnexpectedValueException::class, 'The given netmask is invalid. Skipped bit found between netmask2 and netmask3.');

it('throws an exception when netmask skips a bit between netmask3 and netmask4', function () {
    expect(IPv4Netmask::parse('255.255.254.128'));
})->throws(UnexpectedValueException::class, 'The given netmask is invalid. Skipped bit found between netmask3 and netmask4.');
