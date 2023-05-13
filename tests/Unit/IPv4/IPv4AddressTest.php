<?php

declare(strict_types=1);

use NorseBlue\NetworkAddresses\IPv4\Contracts\IPv4Netmask;
use NorseBlue\NetworkAddresses\IPv4\IPv4Address;

test('creates an IPv4Address from string', function () {
    $ip_address = IPv4Address::parse('0.0.0.0');
    expect($ip_address)->toBeInstanceOf(IPv4Address::class)
        ->and($ip_address->octet1)->toBe(0)
        ->and($ip_address->octet2)->toBe(0)
        ->and($ip_address->octet3)->toBe(0)
        ->and($ip_address->octet4)->toBe(0)
        ->and($ip_address->netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($ip_address->netmask->bits)->toBe(32);

    $ip_address = IPv4Address::parse('127.0.0.1');
    expect($ip_address)->toBeInstanceOf(IPv4Address::class)
        ->and($ip_address->octet1)->toBe(127)
        ->and($ip_address->octet2)->toBe(0)
        ->and($ip_address->octet3)->toBe(0)
        ->and($ip_address->octet4)->toBe(1)
        ->and($ip_address->netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($ip_address->netmask->bits)->toBe(32);

    $ip_address = IPv4Address::parse('192.0.0.0');
    expect($ip_address->octet1)->toBe(192)
        ->and($ip_address->octet2)->toBe(0)
        ->and($ip_address->octet3)->toBe(0)
        ->and($ip_address->octet4)->toBe(0)
        ->and($ip_address->netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($ip_address->netmask->bits)->toBe(32);

    $ip_address = IPv4Address::parse('192.168.0.0');
    expect($ip_address->octet1)->toBe(192)
        ->and($ip_address->octet2)->toBe(168)
        ->and($ip_address->octet3)->toBe(0)
        ->and($ip_address->octet4)->toBe(0)
        ->and($ip_address->netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($ip_address->netmask->bits)->toBe(32);

    $ip_address = IPv4Address::parse('192.168.1.0');
    expect($ip_address->octet1)->toBe(192)
        ->and($ip_address->octet2)->toBe(168)
        ->and($ip_address->octet3)->toBe(1)
        ->and($ip_address->octet4)->toBe(0)
        ->and($ip_address->netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($ip_address->netmask->bits)->toBe(32);

    $ip_address = IPv4Address::parse('192.168.1.254');
    expect($ip_address->octet1)->toBe(192)
        ->and($ip_address->octet2)->toBe(168)
        ->and($ip_address->octet3)->toBe(1)
        ->and($ip_address->octet4)->toBe(254)
        ->and($ip_address->netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($ip_address->netmask->bits)->toBe(32);
});

test('creates an IPv4Address from string with netmask octets', function () {
    $ip_address = IPv4Address::parse('0.0.0.0 255.255.255.0');
    expect($ip_address)->toBeInstanceOf(IPv4Address::class)
        ->and($ip_address->octet1)->toBe(0)
        ->and($ip_address->octet2)->toBe(0)
        ->and($ip_address->octet3)->toBe(0)
        ->and($ip_address->octet4)->toBe(0)
        ->and($ip_address->netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($ip_address->netmask->bits)->toBe(24);

    $ip_address = IPv4Address::parse('127.0.0.1 255.255.255.0');
    expect($ip_address)->toBeInstanceOf(IPv4Address::class)
        ->and($ip_address->octet1)->toBe(127)
        ->and($ip_address->octet2)->toBe(0)
        ->and($ip_address->octet3)->toBe(0)
        ->and($ip_address->octet4)->toBe(1)
        ->and($ip_address->netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($ip_address->netmask->bits)->toBe(24);

    $ip_address = IPv4Address::parse('192.0.0.0 255.255.255.0');
    expect($ip_address->octet1)->toBe(192)
        ->and($ip_address->octet2)->toBe(0)
        ->and($ip_address->octet3)->toBe(0)
        ->and($ip_address->octet4)->toBe(0)
        ->and($ip_address->netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($ip_address->netmask->bits)->toBe(24);

    $ip_address = IPv4Address::parse('192.168.0.0 255.255.255.0');
    expect($ip_address->octet1)->toBe(192)
        ->and($ip_address->octet2)->toBe(168)
        ->and($ip_address->octet3)->toBe(0)
        ->and($ip_address->octet4)->toBe(0)
        ->and($ip_address->netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($ip_address->netmask->bits)->toBe(24);

    $ip_address = IPv4Address::parse('192.168.1.0 255.255.255.0');
    expect($ip_address->octet1)->toBe(192)
        ->and($ip_address->octet2)->toBe(168)
        ->and($ip_address->octet3)->toBe(1)
        ->and($ip_address->octet4)->toBe(0)
        ->and($ip_address->netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($ip_address->netmask->bits)->toBe(24);

    $ip_address = IPv4Address::parse('192.168.1.254 255.255.255.0');
    expect($ip_address->octet1)->toBe(192)
        ->and($ip_address->octet2)->toBe(168)
        ->and($ip_address->octet3)->toBe(1)
        ->and($ip_address->octet4)->toBe(254)
        ->and($ip_address->netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($ip_address->netmask->bits)->toBe(24);
});

test('creates an IPv4Address from string with CIDR notation', function () {
    $ip_address = IPv4Address::parse('0.0.0.0/32');
    expect($ip_address)->toBeInstanceOf(IPv4Address::class)
        ->and($ip_address->octet1)->toBe(0)
        ->and($ip_address->octet2)->toBe(0)
        ->and($ip_address->octet3)->toBe(0)
        ->and($ip_address->octet4)->toBe(0)
        ->and($ip_address->netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($ip_address->netmask->bits)->toBe(32);

    $ip_address = IPv4Address::parse('127.0.0.1/32');
    expect($ip_address)->toBeInstanceOf(IPv4Address::class)
        ->and($ip_address->octet1)->toBe(127)
        ->and($ip_address->octet2)->toBe(0)
        ->and($ip_address->octet3)->toBe(0)
        ->and($ip_address->octet4)->toBe(1)
        ->and($ip_address->netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($ip_address->netmask->bits)->toBe(32);

    $ip_address = IPv4Address::parse('10.0.0.0/8');
    expect($ip_address->octet1)->toBe(10)
        ->and($ip_address->octet2)->toBe(0)
        ->and($ip_address->octet3)->toBe(0)
        ->and($ip_address->octet4)->toBe(0)
        ->and($ip_address->netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($ip_address->netmask->bits)->toBe(8);

    $ip_address = IPv4Address::parse('172.16.0.0/16');
    expect($ip_address->octet1)->toBe(172)
        ->and($ip_address->octet2)->toBe(16)
        ->and($ip_address->octet3)->toBe(0)
        ->and($ip_address->octet4)->toBe(0)
        ->and($ip_address->netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($ip_address->netmask->bits)->toBe(16);

    $ip_address = IPv4Address::parse('192.168.1.0/24');
    expect($ip_address->octet1)->toBe(192)
        ->and($ip_address->octet2)->toBe(168)
        ->and($ip_address->octet3)->toBe(1)
        ->and($ip_address->octet4)->toBe(0)
        ->and($ip_address->netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($ip_address->netmask->bits)->toBe(24);

    $ip_address = IPv4Address::parse('192.168.1.254/24');
    expect($ip_address->octet1)->toBe(192)
        ->and($ip_address->octet2)->toBe(168)
        ->and($ip_address->octet3)->toBe(1)
        ->and($ip_address->octet4)->toBe(254)
        ->and($ip_address->netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($ip_address->netmask->bits)->toBe(24);
});

test('creates an IPv4Address from string replacing netmask with second parameter', function () {
    $ip_address = IPv4Address::parse('192.168.1.254 0.0.0.0', netmask: '255.255.255.0');
    expect($ip_address->octet1)->toBe(192)
        ->and($ip_address->octet2)->toBe(168)
        ->and($ip_address->octet3)->toBe(1)
        ->and($ip_address->octet4)->toBe(254)
        ->and($ip_address->netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($ip_address->netmask->bits)->toBe(24);

    $ip_address = IPv4Address::parse('192.168.1.254/0', netmask: '255.255.255.0');
    expect($ip_address->octet1)->toBe(192)
        ->and($ip_address->octet2)->toBe(168)
        ->and($ip_address->octet3)->toBe(1)
        ->and($ip_address->octet4)->toBe(254)
        ->and($ip_address->netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($ip_address->netmask->bits)->toBe(24);
});

it('throws an exception when ip address octet1 is greater than the max value', function () {
    IPv4Address::parse('256.0.0.0');
})->throws(UnexpectedValueException::class, "IPv4 address '256.0.0.0' is not valid.");

it('throws an exception when ip address octet2 is greater than the max value', function () {
    IPv4Address::parse('255.256.0.0');
})->throws(UnexpectedValueException::class, "IPv4 address '255.256.0.0' is not valid.");

it('throws an exception when ip address octet3 is greater than the max value', function () {
    IPv4Address::parse('255.255.256.0');
})->throws(UnexpectedValueException::class, "IPv4 address '255.255.256.0' is not valid.");

it('throws an exception when ip address octet4 is greater than the max value', function () {
    IPv4Address::parse('255.255.255.256');
})->throws(UnexpectedValueException::class, "IPv4 address '255.255.255.256' is not valid.");

test('creates an IPv4Address from int octets', function () {
    $ip_address = IPv4Address::build(0, 0, 0, 0);
    expect($ip_address)->toBeInstanceOf(IPv4Address::class)
        ->and($ip_address->octet1)->toBe(0)
        ->and($ip_address->octet2)->toBe(0)
        ->and($ip_address->octet3)->toBe(0)
        ->and($ip_address->octet4)->toBe(0)
        ->and($ip_address->netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($ip_address->netmask->netmask1)->toBe(255)
        ->and($ip_address->netmask->netmask2)->toBe(255)
        ->and($ip_address->netmask->netmask3)->toBe(255)
        ->and($ip_address->netmask->netmask4)->toBe(255);

    $ip_address = IPv4Address::build(127, 0, 0, 1);
    expect($ip_address)->toBeInstanceOf(IPv4Address::class)
        ->and($ip_address->octet1)->toBe(127)
        ->and($ip_address->octet2)->toBe(0)
        ->and($ip_address->octet3)->toBe(0)
        ->and($ip_address->octet4)->toBe(1)
        ->and($ip_address->netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($ip_address->netmask->netmask1)->toBe(255)
        ->and($ip_address->netmask->netmask2)->toBe(255)
        ->and($ip_address->netmask->netmask3)->toBe(255)
        ->and($ip_address->netmask->netmask4)->toBe(255);

    $ip_address = IPv4Address::build(192, 168, 1, 254);
    expect($ip_address)->toBeInstanceOf(IPv4Address::class)
        ->and($ip_address->octet1)->toBe(192)
        ->and($ip_address->octet2)->toBe(168)
        ->and($ip_address->octet3)->toBe(1)
        ->and($ip_address->octet4)->toBe(254)
        ->and($ip_address->netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($ip_address->netmask->netmask1)->toBe(255)
        ->and($ip_address->netmask->netmask2)->toBe(255)
        ->and($ip_address->netmask->netmask3)->toBe(255)
        ->and($ip_address->netmask->netmask4)->toBe(255);

    $ip_address = IPv4Address::build(172, 16, 0, 0, 255, 255, 0, 0);
    expect($ip_address)->toBeInstanceOf(IPv4Address::class)
        ->and($ip_address->octet1)->toBe(172)
        ->and($ip_address->octet2)->toBe(16)
        ->and($ip_address->octet3)->toBe(0)
        ->and($ip_address->octet4)->toBe(0)
        ->and($ip_address->netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($ip_address->netmask->netmask1)->toBe(255)
        ->and($ip_address->netmask->netmask2)->toBe(255)
        ->and($ip_address->netmask->netmask3)->toBe(0)
        ->and($ip_address->netmask->netmask4)->toBe(0);
});

test('creates an IPv4Address from array octets', function () {
    $ip_address = IPv4Address::build([0, 0, 0, 0]);
    expect($ip_address)->toBeInstanceOf(IPv4Address::class)
        ->and($ip_address->octet1)->toBe(0)
        ->and($ip_address->octet2)->toBe(0)
        ->and($ip_address->octet3)->toBe(0)
        ->and($ip_address->octet4)->toBe(0)
        ->and($ip_address->netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($ip_address->netmask->netmask1)->toBe(255)
        ->and($ip_address->netmask->netmask2)->toBe(255)
        ->and($ip_address->netmask->netmask3)->toBe(255)
        ->and($ip_address->netmask->netmask4)->toBe(255);

    $ip_address = IPv4Address::build([127, 0, 0, 1]);
    expect($ip_address)->toBeInstanceOf(IPv4Address::class)
        ->and($ip_address->octet1)->toBe(127)
        ->and($ip_address->octet2)->toBe(0)
        ->and($ip_address->octet3)->toBe(0)
        ->and($ip_address->octet4)->toBe(1)
        ->and($ip_address->netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($ip_address->netmask->netmask1)->toBe(255)
        ->and($ip_address->netmask->netmask2)->toBe(255)
        ->and($ip_address->netmask->netmask3)->toBe(255)
        ->and($ip_address->netmask->netmask4)->toBe(255);

    $ip_address = IPv4Address::build([192, 168, 1, 254]);
    expect($ip_address)->toBeInstanceOf(IPv4Address::class)
        ->and($ip_address->octet1)->toBe(192)
        ->and($ip_address->octet2)->toBe(168)
        ->and($ip_address->octet3)->toBe(1)
        ->and($ip_address->octet4)->toBe(254)
        ->and($ip_address->netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($ip_address->netmask->netmask1)->toBe(255)
        ->and($ip_address->netmask->netmask2)->toBe(255)
        ->and($ip_address->netmask->netmask3)->toBe(255)
        ->and($ip_address->netmask->netmask4)->toBe(255);

    $ip_address = IPv4Address::build([172, 16, 0, 0, 255, 255, 0, 0]);
    expect($ip_address)->toBeInstanceOf(IPv4Address::class)
        ->and($ip_address->octet1)->toBe(172)
        ->and($ip_address->octet2)->toBe(16)
        ->and($ip_address->octet3)->toBe(0)
        ->and($ip_address->octet4)->toBe(0)
        ->and($ip_address->netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($ip_address->netmask->netmask1)->toBe(255)
        ->and($ip_address->netmask->netmask2)->toBe(255)
        ->and($ip_address->netmask->netmask3)->toBe(0)
        ->and($ip_address->netmask->netmask4)->toBe(0);
});

it('throws an exception when octet and netmask arrays have more than 0 but less than 4 elements', function () {
    IPv4Address::build([1, 2, 3]);
})->throws(UnexpectedValueException::class, 'The given array must contain 0, 4 or 8 elements describing the octets for the IPv4 address and the IPv4 netmask.');

it('throws an exception when octet and netmask arrays have more than 4 but less than 8 elements', function () {
    IPv4Address::build([1, 2, 3, 4, 5, 6, 7]);
})->throws(UnexpectedValueException::class, 'The given array must contain 0, 4 or 8 elements describing the octets for the IPv4 address and the IPv4 netmask.');

it('truncates array to 8 elements when the octet and netmask arrays have more than 8 elements', function () {
    $ip_address = IPv4Address::build([172, 16, 23, 8, 255, 255, 255, 255, 255, 255, 255]);
    expect($ip_address)->toBeInstanceOf(IPv4Address::class)
        ->and($ip_address->octet1)->toBe(172)
        ->and($ip_address->octet2)->toBe(16)
        ->and($ip_address->octet3)->toBe(23)
        ->and($ip_address->octet4)->toBe(8)
        ->and($ip_address->netmask)->toBeInstanceOf(IPv4Netmask::class)
        ->and($ip_address->netmask->netmask1)->toBe(255)
        ->and($ip_address->netmask->netmask2)->toBe(255)
        ->and($ip_address->netmask->netmask3)->toBe(255)
        ->and($ip_address->netmask->netmask4)->toBe(255);
});

test('retrieves the octets in an IPv4Address address with custom prefix', function () {
    $ip_address = IPv4Address::parse('0.0.0.0');
    expect($ip_address)->toBeInstanceOf(IPv4Address::class)
        ->and($ip_address->octets())->toBe([
            'octet1' => 0,
            'octet2' => 0,
            'octet3' => 0,
            'octet4' => 0,
        ]);

    $ip_address = IPv4Address::parse('127.0.0.1');
    expect($ip_address)->toBeInstanceOf(IPv4Address::class)
        ->and($ip_address->octets())->toBe([
            'octet1' => 127,
            'octet2' => 0,
            'octet3' => 0,
            'octet4' => 1,
        ]);

    $ip_address = IPv4Address::parse('10.0.0.0');
    expect($ip_address)->toBeInstanceOf(IPv4Address::class)
        ->and($ip_address->octets())->toBe([
            'octet1' => 10,
            'octet2' => 0,
            'octet3' => 0,
            'octet4' => 0,
        ]);

    $ip_address = IPv4Address::parse('172.16.0.0');
    expect($ip_address)->toBeInstanceOf(IPv4Address::class)
        ->and($ip_address->octets())->toBe([
            'octet1' => 172,
            'octet2' => 16,
            'octet3' => 0,
            'octet4' => 0,
        ]);

    $ip_address = IPv4Address::parse('192.168.1.0');
    expect($ip_address)->toBeInstanceOf(IPv4Address::class)
        ->and($ip_address->octets())->toBe([
            'octet1' => 192,
            'octet2' => 168,
            'octet3' => 1,
            'octet4' => 0,
        ]);
});

test('retrieves the octets in an IPv4Address address with default prefix', function () {
    $ip_address = IPv4Address::parse('0.0.0.0');
    expect($ip_address)->toBeInstanceOf(IPv4Address::class)
        ->and($ip_address->octets('value'))->toBe([
            'value1' => 0,
            'value2' => 0,
            'value3' => 0,
            'value4' => 0,
        ]);

    $ip_address = IPv4Address::parse('127.0.0.1');
    expect($ip_address)->toBeInstanceOf(IPv4Address::class)
        ->and($ip_address->octets('value'))->toBe([
            'value1' => 127,
            'value2' => 0,
            'value3' => 0,
            'value4' => 1,
        ]);

    $ip_address = IPv4Address::parse('10.0.0.0');
    expect($ip_address)->toBeInstanceOf(IPv4Address::class)
        ->and($ip_address->octets('value'))->toBe([
            'value1' => 10,
            'value2' => 0,
            'value3' => 0,
            'value4' => 0,
        ]);

    $ip_address = IPv4Address::parse('172.16.0.0');
    expect($ip_address)->toBeInstanceOf(IPv4Address::class)
        ->and($ip_address->octets('value'))->toBe([
            'value1' => 172,
            'value2' => 16,
            'value3' => 0,
            'value4' => 0,
        ]);

    $ip_address = IPv4Address::parse('192.168.1.0');
    expect($ip_address)->toBeInstanceOf(IPv4Address::class)
        ->and($ip_address->octets('value'))->toBe([
            'value1' => 192,
            'value2' => 168,
            'value3' => 1,
            'value4' => 0,
        ]);
});

test('caclulates the IPv4 network address', function () {
    $ip_address = IPv4Address::parse('0.0.0.0')->networkAddress();
    expect($ip_address)->toBeInstanceOf(IPv4Address::class)
        ->and($ip_address->format())->toBe('0.0.0.0/32');

    $ip_address = IPv4Address::parse('127.0.0.1')->networkAddress();
    expect($ip_address)->toBeInstanceOf(IPv4Address::class)
        ->and($ip_address->format())->toBe('127.0.0.1/32');

    $ip_address = IPv4Address::parse('10.0.0.0')->networkAddress();
    expect($ip_address)->toBeInstanceOf(IPv4Address::class)
        ->and($ip_address->format())->toBe('10.0.0.0/32');

    $ip_address = IPv4Address::parse('10.0.0.0/8')->networkAddress();
    expect($ip_address)->toBeInstanceOf(IPv4Address::class)
        ->and($ip_address->format())->toBe('10.0.0.0/32');

    $ip_address = IPv4Address::parse('172.16.0.0')->networkAddress();
    expect($ip_address)->toBeInstanceOf(IPv4Address::class)
        ->and($ip_address->format())->toBe('172.16.0.0/32');

    $ip_address = IPv4Address::parse('172.16.0.0/16')->networkAddress();
    expect($ip_address)->toBeInstanceOf(IPv4Address::class)
        ->and($ip_address->format())->toBe('172.16.0.0/32');

    $ip_address = IPv4Address::parse('172.16.0.0/12')->networkAddress();
    expect($ip_address)->toBeInstanceOf(IPv4Address::class)
        ->and($ip_address->format())->toBe('172.16.0.0/32');

    $ip_address = IPv4Address::parse('192.168.1.0')->networkAddress();
    expect($ip_address)->toBeInstanceOf(IPv4Address::class)
        ->and($ip_address->format())->toBe('192.168.1.0/32');

    $ip_address = IPv4Address::parse('192.168.1.0/24')->networkAddress();
    expect($ip_address)->toBeInstanceOf(IPv4Address::class)
        ->and($ip_address->format())->toBe('192.168.1.0/32');
});

test('caclulates the IPv4 broadcast address', function () {
    $ip_address = IPv4Address::parse('0.0.0.0')->broadcastAddress();
    expect($ip_address)->toBeInstanceOf(IPv4Address::class)
        ->and($ip_address->format())->toBe('0.0.0.0/32');

    $ip_address = IPv4Address::parse('127.0.0.1')->broadcastAddress();
    expect($ip_address)->toBeInstanceOf(IPv4Address::class)
        ->and($ip_address->format())->toBe('127.0.0.1/32');

    $ip_address = IPv4Address::parse('10.0.0.0')->broadcastAddress();
    expect($ip_address)->toBeInstanceOf(IPv4Address::class)
        ->and($ip_address->format())->toBe('10.0.0.0/32');

    $ip_address = IPv4Address::parse('10.0.0.0/8')->broadcastAddress();
    expect($ip_address)->toBeInstanceOf(IPv4Address::class)
        ->and($ip_address->format())->toBe('10.255.255.255/32');

    $ip_address = IPv4Address::parse('172.16.0.0')->broadcastAddress();
    expect($ip_address)->toBeInstanceOf(IPv4Address::class)
        ->and($ip_address->format())->toBe('172.16.0.0/32');

    $ip_address = IPv4Address::parse('172.16.0.0/16')->broadcastAddress();
    expect($ip_address)->toBeInstanceOf(IPv4Address::class)
        ->and($ip_address->format())->toBe('172.16.255.255/32');

    $ip_address = IPv4Address::parse('172.16.0.0/12')->broadcastAddress();
    expect($ip_address)->toBeInstanceOf(IPv4Address::class)
        ->and($ip_address->format())->toBe('172.31.255.255/32');

    $ip_address = IPv4Address::parse('192.168.1.0')->broadcastAddress();
    expect($ip_address)->toBeInstanceOf(IPv4Address::class)
        ->and($ip_address->format())->toBe('192.168.1.0/32');

    $ip_address = IPv4Address::parse('192.168.1.0/24')->broadcastAddress();
    expect($ip_address)->toBeInstanceOf(IPv4Address::class)
        ->and($ip_address->format())->toBe('192.168.1.255/32');
});
