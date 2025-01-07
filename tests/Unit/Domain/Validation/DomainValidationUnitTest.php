<?php

namespace Tests\Unit\Domain\Validation;

use Core\Domain\Validation\DomainValidation;
use Core\Domain\Exception\EntityValidationException;
use \PHPUnit\Framework\TestCase;
use Throwable;

class DomainValidationUnitTest extends TestCase
{
    public function testNotNull()
    {
        try {
            $value = '';
            DomainValidation::notNull($value);

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
        }
    }

    public function testNotNullCustomMessageException()
    {
        try {
            $value = '';
            DomainValidation::notNull($value, 'custom message error');

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th, 'custom message error');
        }
    }

    public function testStrMaxLength()
    {
        try {
            $value = 'testetestse';
            DomainValidation::strMaxLength($value, 3, 'custom message error');

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th, 'custom message error');
        }
    }

    public function testStrMinLength()
    {
        try {
            $value = 'Test';
            DomainValidation::strMinLength($value, 8, 'custom message error');

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th, 'custom message error');
        }
    }

    public function testStrCanNullMaxLength()
    {
        try {
            $value = 'teste';
            DomainValidation::strCanNullMaxLength($value, 3, 'custom message error');

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th, 'custom message error');
        }
    }
}