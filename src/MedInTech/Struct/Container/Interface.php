<?php

interface MedInTech_Struct_Container_Interface extends ArrayAccess, Countable
{
  public function set($key, $value);
  public function get($key, $default = null);
  public function has($key);
  public function remove($key);

  public function all();
  public function keys();
}