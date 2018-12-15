<?php

use PHPUnit\Framework\TestCase;

class MappedTest extends TestCase
{
  /** @var MedInTech_Struct_Collection_Interface */
  private $c;
  protected function setUp()
  {
    $this->c = new MedInTech_Struct_Collection_Array(array(), 0, 'MedInTech_Struct_Collection_MapIterator');
  }

  public function testDouble()
  {
    $this->c->clear(array(1, 2, 3));
    /** @var MedInTech_Struct_Collection_MapIterator $it */
    $it = $this->c->getIterator();
    $it->setMapper(create_function('$a', 'return 2 * $a;'));

    $this->assertEquals(array(2, 4, 6), iterator_to_array($it));
  }

}