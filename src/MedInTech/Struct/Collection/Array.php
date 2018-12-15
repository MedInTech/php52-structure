<?php

class MedInTech_Struct_Collection_Array extends ArrayObject implements MedInTech_Struct_Collection_Interface
{
  protected function createFrom(array $elements = array())
  {
    $static = get_class($this);

    return new $static($elements);
  }

  public function add($element)
  {
    $this->append($element);
  }
  public function clear(array $elements = array())
  {
    $this->exchangeArray($elements);
  }
  public function contains($element)
  {
    return in_array($element, $this->toArray(), true);
  }
  public function isEmpty()
  {
    return count($this) === 0;
  }
  public function remove($key)
  {
    if (!isset($this[$key])) {
      return null;
    }
    $removed = $this[$key];
    unset($this[$key]);

    return $removed;
  }
  public function removeElement($element)
  {
    $key = $this->indexOf($element);
    if ($key !== false) {
      return $this->remove($key);
    }

    return null;
  }
  public function containsKey($key)
  {
    return $this->offsetExists($key);
  }
  public function get($key) { return $this[$key]; }
  public function getKeys() { return array_keys($this->toArray()); }
  public function getValues() { return array_values($this->toArray()); }
  public function set($key, $value) { $this[$key] = $value; }
  public function toArray() { return $this->getArrayCopy(); }
  public function first() { return reset($this->toArray()); }
  public function last() { return end($this->toArray()); }
  public function key() { return key($this->toArray()); }
  public function current() { return current($this->toArray()); }
  public function next() { return next($this->toArray()); }
  public function exists($func)
  {
    foreach ($this as $key => $item) {
      if ($func($item, $key)) return true;
    }

    return false;
  }
  public function filter($func)
  {
    return $this->createFrom(array_filter($this->toArray(), $func));
  }
  public function forAll($func)
  {
    foreach ($this as $key => $item) {
      if (!$func($item, $key)) return false;
    }

    return true;
  }
  public function map($func)
  {
    return $this->createFrom(array_map($func, $this->getValues(), $this->getKeys()));
  }
  public function partition($func)
  {

    $matches = $noMatches = array();

    foreach ($this as $key => $element) {
      if ($func($element, $key)) {
        $matches[$key] = $element;
      } else {
        $noMatches[$key] = $element;
      }
    }

    return array($this->createFrom($matches), $this->createFrom($noMatches));
  }
  public function indexOf($element)
  {
    return array_search($element, $this->toArray(), true);
  }

  public function slice($offset, $length = null)
  {
    return $this->createFrom(array_slice($this->toArray(), $offset, $length));
  }
}
