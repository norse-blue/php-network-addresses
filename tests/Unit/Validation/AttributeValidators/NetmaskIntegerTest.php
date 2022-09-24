<?php

declare(strict_types=1);

use NorseBlue\NetworkAddresses\Validation\AttributeValidators\NetmaskInteger;

it('validates an integer as a valid octet', function () {
    $validator = new NetmaskInteger();

    $this->assertTrue($validator->validate(0)->isValid);
    $this->assertTrue($validator->validate(128)->isValid);
    $this->assertTrue($validator->validate(192)->isValid);
    $this->assertTrue($validator->validate(224)->isValid);
    $this->assertTrue($validator->validate(240)->isValid);
    $this->assertTrue($validator->validate(248)->isValid);
    $this->assertTrue($validator->validate(252)->isValid);
    $this->assertTrue($validator->validate(254)->isValid);
    $this->assertTrue($validator->validate(255)->isValid);
});

it('it detects the given odd integer as invalid because the given value is not a valid subnet mask octet', function () {
    $validator = new NetmaskInteger();

    $result = $validator->validate(127);
    $this->assertFalse($result->isValid);
    $this->assertEquals('Value `127` is not a valid mask octet number.', $result->message);

    $result = $validator->validate(53);
    $this->assertFalse($result->isValid);
    $this->assertEquals('Value `53` is not a valid mask octet number.', $result->message);

    $result = $validator->validate(239);
    $this->assertFalse($result->isValid);
    $this->assertEquals('Value `239` is not a valid mask octet number.', $result->message);
});

it('it detects the given even integer as invalid because the given value is not a valid subnet mask octet', function () {
    $validator = new NetmaskInteger();

    $result = $validator->validate(118);
    $this->assertFalse($result->isValid);
    $this->assertEquals('Value `118` is not a valid mask octet number.', $result->message);

    $result = $validator->validate(60);
    $this->assertFalse($result->isValid);
    $this->assertEquals('Value `60` is not a valid mask octet number.', $result->message);

    $result = $validator->validate(220);
    $this->assertFalse($result->isValid);
    $this->assertEquals('Value `220` is not a valid mask octet number.', $result->message);
});
