<?php

declare(strict_types=1);

use NorseBlue\NetworkAddresses\Exceptions\IPv4\InvalidIPv4AddressRangeException;
use NorseBlue\NetworkAddresses\IPv4\IPv4AddressRange;

test('creates an IPv4 address range from a single CIDR address', function () {
    $range = IPv4AddressRange::build('0.0.0.0/32');
    expect($range)->toBeInstanceOf(IPv4AddressRange::class)
        ->and($range->start_address->format())->toBe('0.0.0.0/32')
        ->and($range->end_address->format())->toBe('0.0.0.0/32');

    $range = IPv4AddressRange::build('127.0.0.1/32');
    expect($range)->toBeInstanceOf(IPv4AddressRange::class)
        ->and($range->start_address->format())->toBe('127.0.0.1/32')
        ->and($range->end_address->format())->toBe('127.0.0.1/32');

    $range = IPv4AddressRange::build('10.0.0.0/32');
    expect($range)->toBeInstanceOf(IPv4AddressRange::class)
        ->and($range->start_address->format())->toBe('10.0.0.0/32')
        ->and($range->end_address->format())->toBe('10.0.0.0/32');

    $range = IPv4AddressRange::build('10.0.0.0/24');
    expect($range)->toBeInstanceOf(IPv4AddressRange::class)
        ->and($range->start_address->format())->toBe('10.0.0.0/32')
        ->and($range->end_address->format())->toBe('10.0.0.255/32');

    $range = IPv4AddressRange::build('10.0.0.0/16');
    expect($range)->toBeInstanceOf(IPv4AddressRange::class)
        ->and($range->start_address->format())->toBe('10.0.0.0/32')
        ->and($range->end_address->format())->toBe('10.0.255.255/32');

    $range = IPv4AddressRange::build('10.0.0.0/8');
    expect($range)->toBeInstanceOf(IPv4AddressRange::class)
        ->and($range->start_address->format())->toBe('10.0.0.0/32')
        ->and($range->end_address->format())->toBe('10.255.255.255/32');

    $range = IPv4AddressRange::build('172.16.0.0/32');
    expect($range)->toBeInstanceOf(IPv4AddressRange::class)
        ->and($range->start_address->format())->toBe('172.16.0.0/32')
        ->and($range->end_address->format())->toBe('172.16.0.0/32');

    $range = IPv4AddressRange::build('172.16.0.0/16');
    expect($range)->toBeInstanceOf(IPv4AddressRange::class)
        ->and($range->start_address->format())->toBe('172.16.0.0/32')
        ->and($range->end_address->format())->toBe('172.16.255.255/32');

    $range = IPv4AddressRange::build('172.16.0.0/12');
    expect($range)->toBeInstanceOf(IPv4AddressRange::class)
        ->and($range->start_address->format())->toBe('172.16.0.0/32')
        ->and($range->end_address->format())->toBe('172.31.255.255/32');

    $range = IPv4AddressRange::build('192.168.1.0/32');
    expect($range)->toBeInstanceOf(IPv4AddressRange::class)
        ->and($range->start_address->format())->toBe('192.168.1.0/32')
        ->and($range->end_address->format())->toBe('192.168.1.0/32');

    $range = IPv4AddressRange::build('192.168.1.0/24');
    expect($range)->toBeInstanceOf(IPv4AddressRange::class)
        ->and($range->start_address->format())->toBe('192.168.1.0/32')
        ->and($range->end_address->format())->toBe('192.168.1.255/32');
});

test('creates and IPv4 address range when two IPv4 address are given', function () {
    $range = IPv4AddressRange::build('0.0.0.0', '255.255.255.255');
    expect($range)->toBeInstanceOf(IPv4AddressRange::class)
        ->and($range->start_address->format())->toBe('0.0.0.0/32')
        ->and($range->end_address->format())->toBe('255.255.255.255/32');

    $range = IPv4AddressRange::build('192.168.1.1', '192.168.1.2');
    expect($range)->toBeInstanceOf(IPv4AddressRange::class)
        ->and($range->start_address->format())->toBe('192.168.1.1/32')
        ->and($range->end_address->format())->toBe('192.168.1.2/32');

    $range = IPv4AddressRange::build('192.168.1.0', '192.168.5.32');
    expect($range)->toBeInstanceOf(IPv4AddressRange::class)
        ->and($range->start_address->format())->toBe('192.168.1.0/32')
        ->and($range->end_address->format())->toBe('192.168.5.32/32');
});

test('serializes a range to JSON', function () {
    $range = IPv4AddressRange::build('0.0.0.0', '255.255.255.255');
    expect($range)->toBeInstanceOf(IPv4AddressRange::class)
        ->and(json_encode($range))->toBe('{"start_address":"0.0.0.0\/32","end_address":"255.255.255.255\/32"}');

    $range = IPv4AddressRange::build('192.168.1.1', '192.168.1.2');
    expect($range)->toBeInstanceOf(IPv4AddressRange::class)
        ->and(json_encode($range))->toBe('{"start_address":"192.168.1.1\/32","end_address":"192.168.1.2\/32"}');

    $range = IPv4AddressRange::build('192.168.1.0', '192.168.5.32');
    expect($range)->toBeInstanceOf(IPv4AddressRange::class)
        ->and(json_encode($range))->toBe('{"start_address":"192.168.1.0\/32","end_address":"192.168.5.32\/32"}');
});

it('throws an exception when an invalid range is given', function () {
    $range = IPv4AddressRange::build('192.168.1.39', '192.168.1.1');
})->throws(InvalidIPv4AddressRangeException::class, 'Invalid IPv4 address range given by \'192.168.1.39/32 - 192.168.1.1/32\'.');
