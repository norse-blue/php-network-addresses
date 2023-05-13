<?php

declare(strict_types=1);

use NorseBlue\NetworkAddresses\IPv4\IPv4Address;

it('compares an IPv4Address with an IPv4Address', function () {
    $ip_address = IPv4Address::parse('172.16.9.3/16');

    expect($ip_address->compare(IPv4Address::parse('0.0.0.0/0')))->toBe(1);
    expect($ip_address->compare(IPv4Address::parse('10.0.0.0/8')))->toBe(1);
    expect($ip_address->compare(IPv4Address::parse('172.16.0.0/16')))->toBe(1);
    expect($ip_address->compare(IPv4Address::parse('172.16.9.3/17')))->toBe(1);
    expect($ip_address->compare(IPv4Address::parse('172.16.9.3/16')))->toBe(0);
    expect($ip_address->compare(IPv4Address::parse('172.16.9.3/15')))->toBe(-1);
    expect($ip_address->compare(IPv4Address::parse('192.168.1.0/24')))->toBe(-1);
    expect($ip_address->compare(IPv4Address::parse('255.255.255.255/32')))->toBe(-1);
});

it('compares an IPv4Address to a valid string', function () {
    expect(IPv4Address::parse('172.16.9.3/16')->compare('0.0.0.0/0'))->toBe(1);
    expect(IPv4Address::parse('172.16.9.3/16')->compare('10.0.0.0/8'))->toBe(1);
    expect(IPv4Address::parse('172.16.9.3/16')->compare('172.16.0.0/16'))->toBe(1);
    expect(IPv4Address::parse('172.16.9.3/16')->compare('172.16.9.3/17'))->toBe(1);
    expect(IPv4Address::parse('172.16.9.3/16')->compare('172.16.9.3/16'))->toBe(0);
    expect(IPv4Address::parse('172.16.9.3/16')->compare('172.16.9.3/15'))->toBe(-1);
    expect(IPv4Address::parse('172.16.9.3/16')->compare('192.168.1.0/24'))->toBe(-1);
});

it('equals to an IPv4Address', function () {
    expect(IPv4Address::parse('0.0.0.0')->equals(IPv4Address::parse('0.0.0.0')))->toBe(true);
    expect(IPv4Address::parse('127.0.0.1')->equals(IPv4Address::parse('127.0.0.1')))->toBe(true);
    expect(IPv4Address::parse('10.0.0.0/8')->equals(IPv4Address::parse('10.0.0.0/8')))->toBe(true);
    expect(IPv4Address::parse('172.16.0.0/16')->equals(IPv4Address::parse('172.16.0.0/16')))->toBe(true);
    expect(IPv4Address::parse('192.168.1.0/24')->equals(IPv4Address::parse('192.168.1.0/24')))->toBe(true);
    expect(IPv4Address::parse('255.255.255.255/32')->equals(IPv4Address::parse('255.255.255.255/32')))->toBe(true);
});

it('does not equal to an IPv4Address', function () {
    expect(IPv4Address::parse('0.0.0.0')->equals(IPv4Address::parse('255.255.255.255')))->toBe(false);
    expect(IPv4Address::parse('127.0.0.1')->equals(IPv4Address::parse('0.0.0.0')))->toBe(false);
    expect(IPv4Address::parse('10.0.0.0/8')->equals(IPv4Address::parse('0.0.0.0')))->toBe(false);
    expect(IPv4Address::parse('172.16.0.0/16')->equals(IPv4Address::parse('0.0.0.0')))->toBe(false);
    expect(IPv4Address::parse('192.168.1.0/24')->equals(IPv4Address::parse('0.0.0.0')))->toBe(false);
    expect(IPv4Address::parse('255.255.255.255')->equals(IPv4Address::parse('0.0.0.0')))->toBe(false);
});

it('compares an IPv4Address to an empty string', function () {
    expect(IPv4Address::parse('0.0.0.0')->compare(''))->toBe(0);
    expect(IPv4Address::parse('127.0.0.1')->compare(''))->toBe(1);
    expect(IPv4Address::parse('10.0.0.0/8')->compare(''))->toBe(1);
    expect(IPv4Address::parse('172.16.0.0/16')->compare(''))->toBe(1);
    expect(IPv4Address::parse('192.168.1.0/24')->compare(''))->toBe(1);
    expect(IPv4Address::parse('255.255.255.255/32')->compare(''))->toBe(1);
});

it('compares an IPv4Netmask to a valid string', function () {
    $ip_address = IPv4Address::parse('172.16.9.3/16');

    expect($ip_address->compare('0.0.0.0/0'))->toBe(1);
    expect($ip_address->compare('10.0.0.0/8'))->toBe(1);
    expect($ip_address->compare('172.16.0.0/16'))->toBe(1);
    expect($ip_address->compare('172.16.9.3/17'))->toBe(1);
    expect($ip_address->compare('172.16.9.3/16'))->toBe(0);
    expect($ip_address->compare('172.16.9.3/15'))->toBe(-1);
    expect($ip_address->compare('192.168.1.0/24'))->toBe(-1);
    expect($ip_address->compare('255.255.255.255/32'))->toBe(-1);
});

it('compares an IPv4Address to an empty array', function () {
    expect(IPv4Address::parse('0.0.0.0')->compare([]))->toBe(0);
    expect(IPv4Address::parse('127.0.0.1')->compare([]))->toBe(1);
    expect(IPv4Address::parse('10.0.0.0/8')->compare([]))->toBe(1);
    expect(IPv4Address::parse('172.16.0.0/16')->compare([]))->toBe(1);
    expect(IPv4Address::parse('192.168.1.0/24')->compare([]))->toBe(1);
    expect(IPv4Address::parse('255.255.255.255/32')->compare([]))->toBe(1);
});

it('compares an IPv4Netmask to a valid octet array', function () {
    $ip_address = IPv4Address::parse('172.16.9.3/16');

    expect($ip_address->compare([0, 0, 0, 0, 0, 0, 0, 0]))->toBe(1);
    expect($ip_address->compare([10, 0, 0, 0, 255, 0, 0, 0]))->toBe(1);
    expect($ip_address->compare([172, 16, 0, 0, 255, 255, 0, 0]))->toBe(1);
    expect($ip_address->compare([172, 16, 9, 3, 255, 255, 128, 0]))->toBe(1);
    expect($ip_address->compare([172, 16, 9, 3, 255, 255, 0, 0]))->toBe(0);
    expect($ip_address->compare([172, 16, 9, 3, 255, 254, 0, 0]))->toBe(-1);
    expect($ip_address->compare([192, 168, 1, 0, 255, 255, 255, 0]))->toBe(-1);
    expect($ip_address->compare([255, 255, 255, 255, 255, 255, 255, 255]))->toBe(-1);
});

it('throws an exception when trying to compare an IPv4Address to an bool', function () {
    $netmask = IPv4Address::parse('127.0.0.1');

    $netmask->compare(true);
})->throws(RuntimeException::class, 'Type IPv4Address and type `boolean` are not comparable.');

it('throws an exception when trying to compare an IPv4Address to an int', function () {
    $netmask = IPv4Address::parse('127.0.0.1');

    $netmask->compare(9);
})->throws(RuntimeException::class, 'Type IPv4Address and type `integer` are not comparable.');

it('throws an exception when trying to compare an IPv4Address to an float', function () {
    $netmask = IPv4Address::parse('127.0.0.1');

    $netmask->compare(3.9);
})->throws(RuntimeException::class, 'Type IPv4Address and type `double` are not comparable.');

it('throws an exception when trying to compare an IPv4Address to an stdClass', function () {
    $netmask = IPv4Address::parse('127.0.0.1');

    $netmask->compare(new stdClass());
})->throws(RuntimeException::class, 'Type IPv4Address and type `object` are not comparable.');

it('throws an exception when trying to compare to an invalid string', function () {
    $netmask = IPv4Address::parse('127.0.0.1');

    $netmask->compare('this is not a netmask');
})->throws(RuntimeException::class, 'The value of $something is not a valid IPv4 address to compare to.');

it('throws an exception when trying to compare to an invalid array', function () {
    $netmask = IPv4Address::parse('127.0.0.1');

    $netmask->compare([
        'this',
        'is',
        'not a',
        'netmask',
    ]);
})->throws(RuntimeException::class, 'The value of $something is not a valid IPv4 address to compare to.');
