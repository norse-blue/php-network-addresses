<?php

declare(strict_types=1);

use NorseBlue\NetworkAddresses\Validation\AttributeValidators\IntegerBetween;

it('validates an integer between boundaries', function () {
    $validator = new IntegerBetween(-3, 3);

    $this->assertFalse($validator->validate(-4)->isValid);
    $this->assertTrue($validator->validate(-3)->isValid);
    $this->assertTrue($validator->validate(-2)->isValid);
    $this->assertTrue($validator->validate(-1)->isValid);
    $this->assertTrue($validator->validate(0)->isValid);
    $this->assertTrue($validator->validate(1)->isValid);
    $this->assertTrue($validator->validate(2)->isValid);
    $this->assertTrue($validator->validate(3)->isValid);
    $this->assertFalse($validator->validate(4)->isValid);
});

it('throws an exception when an invalid range is given', function () {
    expect(new IntegerBetween(3, 0));
})->throws(UnexpectedValueException::class, 'Invalid integer range [3, 0] given.');

it('it detects the given value as invalid because it is not an integer', function () {
    $validator = new IntegerBetween(0, 3);

    $result = $validator->validate('string');

    $this->assertFalse($result->isValid);
    $this->assertEquals('The value of $value has to be an integer, `string` given.', $result->message);
});

it('it detects the given value as invalid because the given value is lower than the lower bound', function () {
    $validator = new IntegerBetween(0, 3);

    $result = $validator->validate(-1);

    $this->assertFalse($result->isValid);
    $this->assertEquals('Value `-1` has to be greater than or equal to 0.', $result->message);
});

it('it detects the given value as invalid because the given value is greater than the upper bound', function () {
    $validator = new IntegerBetween(0, 3);

    $result = $validator->validate(4);

    $this->assertFalse($result->isValid);
    $this->assertEquals('Value `4` has to be less than or equal to 3.', $result->message);
});
