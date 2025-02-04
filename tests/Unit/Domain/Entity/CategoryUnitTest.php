<?php

namespace Tests\Unit\Domain\Entity;

use Core\Domain\Entity\Category;
use Core\Domain\Exception\EntityValidationException;
use DateTime;
use \PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Throwable;

class CategoryUnitTest extends TestCase
{
    public function testAttributes()
    {
        $category = new Category(
            name: 'New Cat',
            description: 'New desc',
            isActive: true,
        );

        $this->assertNotEmpty($category->id());
        $this->assertNotEmpty($category->createAt());
        $this->assertEquals('New Cat', $category->name);
        $this->assertEquals('New desc', $category->description);
        $this->assertTrue($category->isActive);
    }

    public function testActivated()
    {
        $category = new Category(
            name: 'New Cat',
            isActive: false,
        );

        $this->assertFalse($category->isActive);
        $category->activate();
        $this->assertTrue($category->isActive);
    }

    public function testDisabled()
    {
        $category = new Category(
            name: 'New Cat'
        );

        $this->assertTrue($category->isActive);
        $category->disable();
        $this->assertFalse($category->isActive);
    }

    public function testUpdate()
    {
        $uuid = (string) Uuid::uuid4()->toString();
        $category = new Category(
            id: $uuid,
            name: 'New Cat',
            description: 'New desc',
            isActive: true,
            createAt: "2024-01-08 09:50:11",
        );

        $category->update(
            name: 'new_Cat',
            description: 'new_desc',
        );
        $this->assertEquals($uuid, $category->id());
        $this->assertEquals('new_Cat', $category->name);
        $this->assertEquals('new_desc', $category->description);
    }

    public function testExceptionName()
    {
        try {
            new Category(
                name: 'Ne',
            );

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
        }
    }

    public function testExceptionDescription()
    {
        try {
            new Category(
                name: 'Name cat',
                description: random_bytes(258),
            );

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
        }
    }
}