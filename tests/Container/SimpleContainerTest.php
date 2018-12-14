<?php

use PHPUnit\Framework\TestCase;

class SimpleContainerTest extends TestCase
{
  public function testSimple()
  {
    $c = new MedInTech_Struct_Container_Simple(array(
      'one' => 1,
    ));
    $c->set('two', 2);
    $c->set('three', 3);
    $c['null'] = null;

    $this->assertEquals(4, $c->count());
    $this->assertEquals(2, $c->get('two'));
    $this->assertTrue($c->has('null'));

    $this->assertEquals(array('one', 'two', 'three', 'null'), $c->keys());
    $this->assertEquals(array(1, 2, 3, null), $c->all());
    $c->remove('three');
    $this->assertEquals(3, $c->count());
    $this->assertFalse($c->has('three'));
  }
  public function testInterfaces()
  {
    $c = new MedInTech_Struct_Container_Simple(array(
      'one' => 1,
    ));
    $c['two'] = 2;
    $c['three'] = 3;
    $c['null'] = null;
    $this->assertEquals(4, count($c));
    $this->assertEquals(2, $c['two']);
    $this->assertTrue(isset($c['null']));

    $this->assertEquals(array('one', 'two', 'three', 'null'), $c->keys());
    $this->assertEquals(array(1, 2, 3, null), $c->all());
    unset($c['three']);
    $this->assertEquals(3, count($c));
    $this->assertFalse(isset($c['three']));
  }
  public function testObject()
  {
    $c = new MedInTech_Struct_Container_Simple(array(
      'one' => 1,
    ));
    $c->two = 2;
    $c->three = 3;
    $c->null = null;
    $this->assertEquals(4, count($c));
    $this->assertEquals(2, $c->two);
    $this->assertTrue(isset($c->null));

    $this->assertEquals(array('one', 'two', 'three', 'null'), $c->keys());
    $this->assertEquals(array(1, 2, 3, null), $c->all());
    unset($c->three);
    $this->assertEquals(3, count($c));
    $this->assertFalse(isset($c->three));
  }
}