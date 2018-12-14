<?php

use PHPUnit\Framework\TestCase;

class CIContainerTest extends TestCase
{
  public function testSimple()
  {
    $c = new MedInTech_Struct_Container_CIKey();
    $c->set('One', 1);
    $this->assertTrue($c->has('ONE'));
    $this->assertTrue($c->has('one'));
    $this->assertEquals(1, $c->get('one'));
  }
}