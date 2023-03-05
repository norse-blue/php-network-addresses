<?php

declare(strict_types=1);

use NorseBlue\NetworkAddresses\IPv4\IPv4Netmask;

it('compares an IPv4Netmask to an IPv4Netmask', function () {
    $netmask = IPv4Netmask::parse('255.255.255.0');

    expect($netmask->compare(IPv4Netmask::parse('255.255.255.192')))->toBe(-1);
    expect($netmask->compare(IPv4Netmask::parse('255.255.255.0')))->toBe(0);
    expect($netmask->compare(IPv4Netmask::parse('255.255.192.0')))->toBe(1);
});

it('equals to an IPv4Netmask', function () {
    expect(IPv4Netmask::parse('255.255.255.192')->equals(IPv4Netmask::parse('255.255.255.192')))->toBe(true);
    expect(IPv4Netmask::parse('255.255.255.0')->equals(IPv4Netmask::parse('255.255.255.0')))->toBe(true);
    expect(IPv4Netmask::parse('255.255.192.0')->equals(IPv4Netmask::parse('255.255.192.0')))->toBe(true);
    expect(IPv4Netmask::parse('255.255.0.0')->equals(IPv4Netmask::parse('255.255.0.0')))->toBe(true);
    expect(IPv4Netmask::parse('255.0.0.0')->equals(IPv4Netmask::parse('255.0.0.0')))->toBe(true);
});

it('does not equal to an IPv4Netmask', function () {
    expect(IPv4Netmask::parse('255.255.255.192')->equals(IPv4Netmask::parse('255.255.255.0')))->toBe(false);
    expect(IPv4Netmask::parse('255.255.255.0')->equals(IPv4Netmask::parse('255.255.0.0')))->toBe(false);
    expect(IPv4Netmask::parse('255.255.192.0')->equals(IPv4Netmask::parse('255.255.0.0')))->toBe(false);
    expect(IPv4Netmask::parse('255.255.0.0')->equals(IPv4Netmask::parse('255.0.0.0')))->toBe(false);
    expect(IPv4Netmask::parse('255.0.0.0')->equals(IPv4Netmask::parse('0.0.0.0')))->toBe(false);
});

it('compares an IPv4Netmask to an empty string', function () {
    expect(IPv4Netmask::parse('255.255.255.0')->compare(''))->toBe(-1);
    expect(IPv4Netmask::parse('255.255.255.192')->compare(''))->toBe(-1);
    expect(IPv4Netmask::parse('255.255.255.255')->compare(''))->toBe(0);
});

it('compares an IPv4Netmask to a valid string', function () {
    $netmask = IPv4Netmask::parse('255.255.255.0');

    expect($netmask->compare('255.255.255.192'))->toBe(-1);
    expect($netmask->compare('255.255.255.0'))->toBe(0);
    expect($netmask->compare('255.255.192.0'))->toBe(1);
});

it('compares an IPv4Netmask to an empty octet array', function () {
    expect(IPv4Netmask::parse('255.255.255.0')->compare([]))->toBe(-1);
    expect(IPv4Netmask::parse('255.255.255.192')->compare([]))->toBe(-1);
    expect(IPv4Netmask::parse('255.255.255.255')->compare([]))->toBe(0);
});

it('compares an IPv4Netmask to a valid octet array', function () {
    $netmask = IPv4Netmask::parse('255.255.255.0');

    expect($netmask->compare([255, 255, 255, 192]))->toBe(-1);
    expect($netmask->compare([255, 255, 255, 0]))->toBe(0);
    expect($netmask->compare([255, 255, 192, 0]))->toBe(1);
});

it('throws an exception when trying to compare an IPv4Netmask to an bool', function () {
    $netmask = IPv4Netmask::parse('255.255.255.0');

    $netmask->compare(true);
})->throws(RuntimeException::class, 'Type IPv4Netmask and type `boolean` are not comparable.');

it('throws an exception when trying to compare an IPv4Netmask to an int', function () {
    $netmask = IPv4Netmask::parse('255.255.255.0');

    $netmask->compare(9);
})->throws(RuntimeException::class, 'Type IPv4Netmask and type `integer` are not comparable.');

it('throws an exception when trying to compare an IPv4Netmask to an float', function () {
    $netmask = IPv4Netmask::parse('255.255.255.0');

    $netmask->compare(3.9);
})->throws(RuntimeException::class, 'Type IPv4Netmask and type `double` are not comparable.');

it('throws an exception when trying to compare an IPv4Netmask to an stdClass', function () {
    $netmask = IPv4Netmask::parse('255.255.255.0');

    $netmask->compare(new stdClass());
})->throws(RuntimeException::class, 'Type IPv4Netmask and type `object` are not comparable.');

it('throws an exception when trying to compare to an invalid string', function () {
    $netmask = IPv4Netmask::parse('255.255.255.0');

    $netmask->compare('this is not a netmask');
})->throws(RuntimeException::class, 'The value of $something is not a valid netmask to compare to.');

it('throws an exception when trying to compare to an invalid array', function () {
    $netmask = IPv4Netmask::parse('255.255.255.0');

    $netmask->compare([
        'this',
        'is',
        'not a',
        'netmask',
    ]);
})->throws(RuntimeException::class, 'The value of $something is not a valid netmask to compare to.');
