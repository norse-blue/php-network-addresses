<?php

declare(strict_types=1);

use NorseBlue\NetworkAddresses\IPv4\Enums\IPv4Format;
use NorseBlue\NetworkAddresses\IPv4\IPv4Address;

it('gets the ip address in Binary format', function () {
    expect(IPv4Address::parse('0.0.0.0/0')->format(IPv4Format::Binary))->toBe('00000000000000000000000000000000 00000000000000000000000000000000');
    expect(IPv4Address::parse('127.0.0.1')->format(IPv4Format::Binary))->toBe('01111111000000000000000000000001 11111111111111111111111111111111');
    expect(IPv4Address::parse('10.0.0.0/8')->format(IPv4Format::Binary))->toBe('00001010000000000000000000000000 11111111000000000000000000000000');
    expect(IPv4Address::parse('172.16.0.0/16')->format(IPv4Format::Binary))->toBe('10101100000100000000000000000000 11111111111111110000000000000000');
    expect(IPv4Address::parse('192.168.1.0/24')->format(IPv4Format::Binary))->toBe('11000000101010000000000100000000 11111111111111111111111100000000');
    expect(IPv4Address::parse('255.255.255.255/32')->format(IPv4Format::Binary))->toBe('11111111111111111111111111111111 11111111111111111111111111111111');
});

it('gets the ip address in Binary format excluding netmask', function () {
    expect(IPv4Address::parse('0.0.0.0/0')->format(IPv4Format::Binary, ['exclude-netmask' => true]))->toBe('00000000000000000000000000000000');
    expect(IPv4Address::parse('127.0.0.1')->format(IPv4Format::Binary, ['exclude-netmask' => true]))->toBe('01111111000000000000000000000001');
    expect(IPv4Address::parse('10.0.0.0/8')->format(IPv4Format::Binary, ['exclude-netmask' => true]))->toBe('00001010000000000000000000000000');
    expect(IPv4Address::parse('172.16.0.0/16')->format(IPv4Format::Binary, ['exclude-netmask' => true]))->toBe('10101100000100000000000000000000');
    expect(IPv4Address::parse('192.168.1.0/24')->format(IPv4Format::Binary, ['exclude-netmask' => true]))->toBe('11000000101010000000000100000000');
    expect(IPv4Address::parse('255.255.255.255/32')->format(IPv4Format::Binary, ['exclude-netmask' => true]))->toBe('11111111111111111111111111111111');
});

it('gets the ip address in CIDR format when casting to string', function () {
    expect((string) IPv4Address::parse('0.0.0.0/0'))->toBe('0.0.0.0/0');
    expect((string) IPv4Address::parse('127.0.0.1'))->toBe('127.0.0.1/32');
    expect((string) IPv4Address::parse('10.0.0.0/8'))->toBe('10.0.0.0/8');
    expect((string) IPv4Address::parse('172.16.0.0/16'))->toBe('172.16.0.0/16');
    expect((string) IPv4Address::parse('192.168.1.0/24'))->toBe('192.168.1.0/24');
    expect((string) IPv4Address::parse('255.255.255.255/32'))->toBe('255.255.255.255/32');
});

it('gets the ip address in CIDR format excluding netmask', function () {
    expect((string) IPv4Address::parse('0.0.0.0/0')->format(IPv4Format::Cidr, ['exclude-netmask' => true]))->toBe('0.0.0.0');
    expect((string) IPv4Address::parse('127.0.0.1')->format(IPv4Format::Cidr, ['exclude-netmask' => true]))->toBe('127.0.0.1');
    expect((string) IPv4Address::parse('10.0.0.0/8')->format(IPv4Format::Cidr, ['exclude-netmask' => true]))->toBe('10.0.0.0');
    expect((string) IPv4Address::parse('172.16.0.0/16')->format(IPv4Format::Cidr, ['exclude-netmask' => true]))->toBe('172.16.0.0');
    expect((string) IPv4Address::parse('192.168.1.0/24')->format(IPv4Format::Cidr, ['exclude-netmask' => true]))->toBe('192.168.1.0');
    expect((string) IPv4Address::parse('255.255.255.255/32')->format(IPv4Format::Cidr, ['exclude-netmask' => true]))->toBe('255.255.255.255');
});

it('gets the ip address in Traditional format', function () {
    expect(IPv4Address::parse('0.0.0.0/0')->format(IPv4Format::Traditional))->toBe('0.0.0.0 0.0.0.0');
    expect(IPv4Address::parse('127.0.0.1')->format(IPv4Format::Traditional))->toBe('127.0.0.1 255.255.255.255');
    expect(IPv4Address::parse('10.0.0.0/8')->format(IPv4Format::Traditional))->toBe('10.0.0.0 255.0.0.0');
    expect(IPv4Address::parse('172.16.0.0/16')->format(IPv4Format::Traditional))->toBe('172.16.0.0 255.255.0.0');
    expect(IPv4Address::parse('192.168.1.0/24')->format(IPv4Format::Traditional))->toBe('192.168.1.0 255.255.255.0');
    expect(IPv4Address::parse('255.255.255.255/32')->format(IPv4Format::Traditional))->toBe('255.255.255.255 255.255.255.255');
});

it('gets the ip address in Traditional format excluding netmask', function () {
    expect(IPv4Address::parse('0.0.0.0/0')->format(IPv4Format::Traditional, ['exclude-netmask' => true]))->toBe('0.0.0.0');
    expect(IPv4Address::parse('127.0.0.1')->format(IPv4Format::Traditional, ['exclude-netmask' => true]))->toBe('127.0.0.1');
    expect(IPv4Address::parse('10.0.0.0/8')->format(IPv4Format::Traditional, ['exclude-netmask' => true]))->toBe('10.0.0.0');
    expect(IPv4Address::parse('172.16.0.0/16')->format(IPv4Format::Traditional, ['exclude-netmask' => true]))->toBe('172.16.0.0');
    expect(IPv4Address::parse('192.168.1.0/24')->format(IPv4Format::Traditional, ['exclude-netmask' => true]))->toBe('192.168.1.0');
    expect(IPv4Address::parse('255.255.255.255/32')->format(IPv4Format::Traditional, ['exclude-netmask' => true]))->toBe('255.255.255.255');
});
