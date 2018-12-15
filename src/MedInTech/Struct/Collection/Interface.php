<?php

interface MedInTech_Struct_Collection_Interface extends Countable, ArrayAccess, IteratorAggregate
{
  public function add($element);
  public function clear(array $elements = array());
  public function contains($element);
  public function isEmpty();
  public function remove($key);
  public function removeElement($element);
  public function containsKey($key);
  public function get($key);
  public function getKeys();
  public function getValues();
  public function set($key, $value);
  public function toArray();
  public function first();
  public function last();
  public function key();
  public function current();
  public function next();
  public function exists($func);
  public function filter($func);
  public function forAll($func);
  public function map($func);
  public function partition($func);
  public function indexOf($element);
  public function slice($offset, $length = null);
}