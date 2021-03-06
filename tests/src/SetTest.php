<?php
declare(strict_types=1);

namespace Ramsey\Collection\Test;

use Ramsey\Collection\AbstractSet;
use Ramsey\Collection\CollectionInterface;
use Ramsey\Collection\Set;
use Ramsey\Collection\Test\Mock\Foo;
use PHPUnit\Framework\TestCase as PhpUnitTestCase;

/**
 * Tests for Set class.
 *
 * As Set is a Collection with no duplicated elements
 * it only test the expected behavior.
 */
class SetTest extends PhpUnitTestCase
{
    /** @var Set */
    private $set;

    protected function setUp()
    {
        $this->set = new Set('int');
    }

    public function testConstructorInheritance()
    {
        $this->assertInstanceOf(CollectionInterface::class, $this->set);
        $this->assertInstanceOf(AbstractSet::class, $this->set);
    }

    public function testConstructGetType()
    {
        $this->assertSame('int', $this->set->getType());
    }

    public function testConstructWithValues()
    {
        $expected = [2, 4, 6, 8];
        $localSet = new Set('int', $expected);
        $this->assertEquals($expected, $localSet->toArray());
    }

    public function testAddDuplicates()
    {
        $this->assertTrue($this->set->add(100));
        $this->assertFalse($this->set->add(100));
        $this->assertSame([100], $this->set->toArray());
    }

    public function testOffsetSetDuplicates()
    {
        $this->set[] = 100;
        $this->set[] = 100;
        $this->assertSame([100], $this->set->toArray());
    }

    public function testUsingEqualButNotIdentical()
    {
        $uniqueFoos = new Set(Foo::class);

        // the comparisons are identical (===), not equal(==)
        $this->assertTrue($uniqueFoos->add(new Foo()));
        $this->assertTrue($uniqueFoos->add(new Foo()));
    }

    public function testUsingIdentical()
    {
        $uniqueFoos = new Set(Foo::class);

        // the comparisons are identical (===), not equal(==)
        $identical = new Foo();
        $this->assertTrue($uniqueFoos->add($identical));
        $this->assertFalse($uniqueFoos->add($identical));
    }
}
