<?php

use PHPUnit\Framework\TestCase;

class ArrayTest extends TestCase
{
  /** @var MedInTech_Struct_Collection_Interface */
  private $c;
  protected function setUp()
  {
    $this->c = new MedInTech_Struct_Collection_Array(array(1, 2, 3));
    $this->c->add(4);
  }
  public function testSimple()
  {
    $this->assertEquals(4, $this->c->count());
    $this->c->clear();

    $this->assertEquals(0, $this->c->count());
    $this->assertTrue($this->c->isEmpty());
  }

  public function testChecks()
  {
    $this->assertFalse($this->c->isEmpty());

    $this->assertTrue($this->c->exists(create_function('$a', 'return $a === 4;')));
    $this->assertTrue($this->c->contains(4));
    $this->assertFalse($this->c->exists(create_function('$a', 'return $a === -1;')));
    $this->assertFalse($this->c->contains(-1));

    $this->assertTrue($this->c->exists(create_function('$a,$k', 'return $k === 2;')));
    $this->assertTrue($this->c->containsKey(2));
    $this->assertFalse($this->c->exists(create_function('$a,$k', 'return $k === 4;')));
    $this->assertFalse($this->c->containsKey(4));

    $this->assertTrue($this->c->forAll(create_function('$a', 'return $a > 0;')));
    $this->assertFalse($this->c->forAll(create_function('$a', 'return $a < 4;')));
  }

  public function testIndexOf()
  {
    $this->assertEquals(3, $this->c->indexOf(4));
    $this->assertFalse($this->c->indexOf(5));
  }

  public function testFilter()
  {
    $this->assertEquals(array(1=>2, 3=>4), (array)$this->c->filter(create_function('$a', 'return $a % 2 === 0;')));
  }

  public function testMap()
  {
    $this->assertEquals(array(2, 4, 6, 8), (array)$this->c->map(create_function('$a', 'return $a * 2;')));
  }

  public function testSlice()
  {
    $this->assertEquals(array(2, 3), (array)$this->c->slice(1, 2));
  }

  public function testPartition()
  {
    $partition = $this->c->partition(create_function('$a', 'return $a % 2 === 0;'));
    $this->assertEquals(array(1=>2, 3=>4), (array)$partition[0]);
    $this->assertEquals(array(0=>1, 2=>3), (array)$partition[1]);
  }

  public function testRemove()
  {
    $three = $this->c->remove(2);
    $this->assertFalse($this->c->containsKey(2));
    $this->assertFalse($this->c->contains(3));
    $this->assertFalse($this->c->indexOf(3));
    $this->assertEquals(3, $three);
    $this->assertNull($this->c->remove(2)); // because keys not recalculate?
  }
  public function testRemoveElement()
  {
    $three = $this->c->removeElement(3);
    $this->assertFalse($this->c->contains(3));
    $this->assertFalse($this->c->indexOf(3));
    $this->assertEquals(3, $three);
    $this->assertNull($this->c->removeElement(3));
  }
}