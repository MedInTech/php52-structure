<?php

class MedInTech_Struct_Container_CIKey extends MedInTech_Struct_Container_Simple
{
  public function convertKey($key)
  {
    return strtolower($key);
  }
}