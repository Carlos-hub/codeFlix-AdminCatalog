<?php

namespace Tests\Unit\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use PHPUnit\Framework\TestCase;

abstract class AbstractModelTestCase extends TestCase
{
    abstract protected function model(): Model;

    abstract protected function traits(): array;
    abstract protected function fillable(): array;
    abstract protected function casts(): array;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testIfUseTraits(): void
    {
        $traits_needed = $this->traits();
        $traits_used = array_keys(class_uses($this->model()));

        $this->assertEquals($traits_needed, $traits_used);
    }

    public function testFillableAttribute()
    {
        $fillable = $this->fillable();
        $this->assertEquals($fillable, $this->model()->getFillable());
    }

    public function testCastsAttribute()
    {
        $casts = $this->casts();
        $this->assertEquals($casts, $this->model()->getCasts());
    }

    public function testIncrementingAttribute()
    {
        $this->assertFalse($this->model()->incrementing);
    }
}
