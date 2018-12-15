<?php

class MedInTech_Struct_Collection_MapIterator extends ArrayIterator
{
  /** @var callable */
  protected $mapper;
  /** @var Iterator */
  protected $innerIterator;

  private function _mapper($el)
  {
    $mapper = $this->mapper;

    return $mapper($el);
  }

  public function setMapper($mapper) { $this->mapper = $mapper; }
  public function current() { return $this->_mapper(parent::current()); }
}