<?php

namespace  Tests\Unit\Domain\Entity;

use Core\Domain\Entity\Category;
use Core\Domain\Exception\EntityValidationException;
use \Ramsey\Uuid\Nonstandard\Uuid;
use PHPUnit\Framework\TestCase;

class CategoryUnitTest extends TestCase
{
    public function testAttributes()
    {
        $category = new Category(
            name: 'Category Test',
            description: 'Description Test',
            isActive: true
        );
        $this->assertNotEmpty($category->id());
        $this->assertNotEmpty($category->createdAt());
        $this->assertEquals('Category Test',$category->name);
        $this->assertEquals('Description Test',$category->description);
        $this->assertEquals(true,$category->isActive);

    }
    public function testActivated()
    {
        $category = new Category(
            name: 'Category Test',
            isActive: false
        );
        $this->assertFalse($category->isActive);

        $category->activated();

        $this->assertTrue($category->isActive);
    }

    public function testDisabled()
    {
        $category = new Category(
            name: 'Category Test',
        );
        $this->assertTrue($category->isActive);

        $category->disabled();

        $this->assertFalse($category->isActive);
    }

    public function testUpdate()
    {
        $uuid = (string) Uuid::uuid4()->toString();
        $category = new Category(
            id : $uuid,
            name: 'Category Test',
            description: 'Description Test',
            isActive: true
        );

        $category->update(
            name: 'Category New Update',
            description: 'Description New Update',
        );

        $this->assertEquals($uuid,$category->id());
        $this->assertEquals('Category New Update',$category->name);
        $this->assertEquals('Description New Update',$category->description);
    }

    public function testUpdateWithoutName()
    {
        $uuid = Uuid::uuid4()->toString();
        $category = new Category(
            name: 'Category Test',
            id: $uuid,
            description: 'Description Test',
            isActive: true
        );

        $category->update(
            description: 'Category New Update',
        );

        $this->assertEquals('Category Test',$category->name);
        $this->assertEquals('Category New Update',$category->description);
    }

    public function testUpdateWithoutDescription()
    {
        $uuid = Uuid::uuid4()->toString();
        $category = new Category(
            name: 'Category Test',
            id: $uuid,
            description: 'Description Test',
            isActive: true
        );

        $category->update(
            name: 'Category New Update',
        );

        $this->assertEquals('Category New Update',$category->name);
        $this->assertEquals('Description Test',$category->description);
    }

    public function testExceptionName(){
        try{
            $uuid = 'uuid.value';
            new Category(
                name: 'AB',
                description: 'Description Test',
            );
            $this->assertTrue(false);
        }catch (\Exception $e){
            $this->assertInstanceOf(EntityValidationException::class,$e);
        }
    }

    public function testExceptionDescription(){
        try{
            new Category(
                name: 'AB',
                description: random_bytes(999),
            );
            $this->assertTrue(false);
        }catch (\Exception $e){
            $this->assertInstanceOf(EntityValidationException::class,$e);
        }
    }
}