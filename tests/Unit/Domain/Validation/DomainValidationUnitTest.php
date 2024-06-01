<?php

namespace Unit\Domain\Validation;

use Core\Domain\Exception\EntityValidationException;
use Core\Domain\Validation\DomainValidation;

class DomainValidationUnitTest extends \PHPUnit\Framework\TestCase
{
    public function testNotNull()
    {
        try {
            $value = '';
            DomainValidation::notNull($value);
            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertInstanceOf(EntityValidationException::class, $e);
        }
    }

    public function testNotNullCustomMessageException()
    {
        try {
            $value = '';
            DomainValidation::notNull($value, 'Custom Exception Message');
            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertInstanceOf(EntityValidationException::class, $e,'Custom Exception Message');
        }
    }

    public function testStrMaxLength()
    {
        try {
            $value = 'Test';
            DomainValidation::strMaxLength($value,3,'Custom Exception Message');
            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertInstanceOf(EntityValidationException::class, $e,'Custom Exception Message');
        }
    }

    public function testStrMinLength()
    {
        try {
            $value = 'Test';
            DomainValidation::strMinLength($value,8,'Custom Exception Message');
            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertInstanceOf(EntityValidationException::class, $e,'Custom Exception Message');
        }
    }
}