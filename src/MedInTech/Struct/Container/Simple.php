<?php

class MedInTech_Struct_Container_Simple extends ArrayObject implements MedInTech_Struct_Container_Interface
{
  protected $keys = array();

  public function __construct(array $values = array())
  {
    $vals = array();
    foreach ($values as $k => $v) {
      $vals[$this->convertKey($k)] = $this->convertInValue($v);
      $this->keys[$this->convertKey($k)] = $k;
    }
    parent::__construct($vals, ArrayObject::ARRAY_AS_PROPS | ArrayObject::STD_PROP_LIST);
  }

  public function set($key, $value) { $this->offsetSet($key, $value); }
  public function get($key, $default = null) { return $this->offsetExists($key) ? $this->offsetGet($key) : $default; }
  public function has($key) { return $this->offsetExists($key); }
  public function remove($key) { $this->offsetUnset($key); }
  public function all()
  {
    $result = array();
    foreach ($this->getArrayCopy() as $value) {
      $result[] = $this->convertOutValue($value);
    }

    return $result;
  }
  public function keys() { return array_values($this->keys); }

  // ArrayAccess
  public function offsetExists($offset)
  {
    return parent::offsetExists($this->convertKey($offset));
  }
  public function offsetGet($offset)
  {
    return parent::offsetGet($this->convertKey($offset));
  }
  public function offsetSet($offset, $value)
  {
    $this->keys[$this->convertKey($offset)] = $offset;
    parent::offsetSet($this->convertKey($offset), $this->convertInValue($value));
  }
  public function offsetUnset($offset)
  {
    unset($this->keys[$this->convertKey($offset)]);
    parent::offsetUnset($this->convertKey($offset));
  }

  public function convertKey($key) { return $key; }
  public function convertInValue($value) { return $value; }
  public function convertOutValue($value) { return $value; }
}