<?php

declare(strict_types=1);

use NorseBlue\NetworkAddresses\IPv4\Enums\IPv4Format;
use NorseBlue\NetworkAddresses\IPv4\IPv4Address;

test('creates an IPv4Address from string', function () {
    $ip_address = IPv4Address::parse('0.0.0.0');
    expect($ip_address)->toBeInstanceOf(IPv4Address::class)
        ->and($ip_address->octet1)->toBe(0)
        ->and($ip_address->octet2)->toBe(0)
        ->and($ip_address->octet3)->toBe(0)
        ->and($ip_address->octet4)->toBe(0);

    $ip_address = IPv4Address::parse('192.0.0.0');
    expect($ip_address->octet1)->toBe(192)
        ->and($ip_address->octet2)->toBe(0)
        ->and($ip_address->octet3)->toBe(0)
        ->and($ip_address->octet4)->toBe(0);

    $ip_address = IPv4Address::parse('192.168.0.0');
    expect($ip_address->octet1)->toBe(192)
        ->and($ip_address->octet2)->toBe(168)
        ->and($ip_address->octet3)->toBe(0)
        ->and($ip_address->octet4)->toBe(0);

    $ip_address = IPv4Address::parse('192.168.1.0');
    expect($ip_address->octet1)->toBe(192)
        ->and($ip_address->octet2)->toBe(168)
        ->and($ip_address->octet3)->toBe(1)
        ->and($ip_address->octet4)->toBe(0);

    $ip_address = IPv4Address::parse('192.168.1.254');
    expect($ip_address->octet1)->toBe(192)
        ->and($ip_address->octet2)->toBe(168)
        ->and($ip_address->octet3)->toBe(1)
        ->and($ip_address->octet4)->toBe(254);
});

it('throws an exception when ip address octet1 greater than the max value', function () {
    expect(IPv4Address::parse('256.0.0.0'));
})->throws(UnexpectedValueException::class, 'IP address 256.0.0.0 is not valid.');

it('throws an exception when ip address octet2 greater than the max value', function () {
    expect(IPv4Address::parse('255.256.0.0'));
})->throws(UnexpectedValueException::class, 'IP address 255.256.0.0 is not valid.');

it('throws an exception when ip address octet3 greater than the max value', function () {
    expect(IPv4Address::parse('255.255.256.0'));
})->throws(UnexpectedValueException::class, 'IP address 255.255.256.0 is not valid.');

it('throws an exception when ip address octet4 greater than the max value', function () {
    expect(IPv4Address::parse('255.255.255.256'));
})->throws(UnexpectedValueException::class, 'IP address 255.255.255.256 is not valid.');

//test('creates an IPv4Address from int octets', function () {
//    expect(IPv4Address::fromOctets(192, 168, 1, 254))->toBeInstanceOf(IPv4Address::class);
//});
//
//test('creates an IPv4Address from array octets', function () {
//    expect(IPv4Address::fromOctets([192, 168, 1, 254]))->toBeInstanceOf(IPv4Address::class);
//});
//
//it('gets the ip address as a decimal string', function () {
//    expect((string) IPv4Address::fromOctets([192, 168, 1, 254]))->toBe('192.168.1.254');
//});
//
//it('gets the ip address formatted as decimal string', function () {
//    expect(IPv4Address::fromOctets([192, 168, 1, 254])->format(IPv4Format::Decimal))->toBe('192.168.1.254');
//});
//
//it('gets the ip address formatted as binary string', function () {
//    expect(IPv4Address::fromOctets([192, 168, 1, 254])->format(IPv4Format::Binary))->toBe('11000000.10101000.00000001.11111110');
//});
//
//it('gets the ip address formatted as octal string', function () {
//    expect(IPv4Address::fromOctets([192, 168, 1, 254])->format(IPv4Format::Octal))->toBe('0300.0250.0001.0376');
//});
//
//it('gets the ip address formatted as hex string', function () {
//    expect(IPv4Address::fromOctets([192, 168, 1, 254])->format(IPv4Format::Hexadecimal))->toBe('c0.a8.01.fe');
//});
