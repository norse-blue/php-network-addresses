<?php

declare(strict_types=1);

use NorseBlue\NetworkAddresses\IPv4\Enums\IPv4Format;
use NorseBlue\NetworkAddresses\IPv4\IPv4Address;

it('gets the ip address in CIDR format when casting to string', function () {
    expect((string) IPv4Address::parse('0.0.0.0/0'))->toBe('0.0.0.0/0');
    expect((string) IPv4Address::parse('127.0.0.1'))->toBe('127.0.0.1/32');
    expect((string) IPv4Address::parse('10.0.0.0/8'))->toBe('10.0.0.0/8');
    expect((string) IPv4Address::parse('172.16.0.0/16'))->toBe('172.16.0.0/16');
    expect((string) IPv4Address::parse('192.168.1.0/24'))->toBe('192.168.1.0/24');
    expect((string) IPv4Address::parse('255.255.255.255/32'))->toBe('255.255.255.255/32');
});

it('gets the ip address in Traditional format', function () {
    expect(IPv4Address::parse('0.0.0.0/0')->format(IPv4Format::Traditional))->toBe('0.0.0.0 0.0.0.0');
    expect(IPv4Address::parse('127.0.0.1')->format(IPv4Format::Traditional))->toBe('127.0.0.1 255.255.255.255');
    expect(IPv4Address::parse('10.0.0.0/8')->format(IPv4Format::Traditional))->toBe('10.0.0.0 255.0.0.0');
    expect(IPv4Address::parse('172.16.0.0/16')->format(IPv4Format::Traditional))->toBe('172.16.0.0 255.255.0.0');
    expect(IPv4Address::parse('192.168.1.0/24')->format(IPv4Format::Traditional))->toBe('192.168.1.0 255.255.255.0');
    expect(IPv4Address::parse('255.255.255.255/32')->format(IPv4Format::Traditional))->toBe('255.255.255.255 255.255.255.255');
});
