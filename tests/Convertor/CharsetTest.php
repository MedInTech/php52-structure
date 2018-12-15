<?php

use PHPUnit\Framework\Error\Warning;
use PHPUnit\Framework\TestCase;

class CharsetTest extends TestCase
{
  public function testStaticIconvStr()
  {
    $str = 'Привет';
    $cp1251 = MedInTech_Convertor_Charset::iconv('utf-8', 'windows-1251', $str);
    $cp1251Hex = 'cff0e8e2e5f2';

    $this->assertEquals($cp1251Hex, bin2hex($cp1251));
    $this->assertEquals($str, MedInTech_Convertor_Charset::iconv('windows-1251', 'utf-8', $cp1251));
  }
  public function testStaticIconvArray()
  {
    $str = 'Привет';
    $cp1251 = MedInTech_Convertor_Charset::iconv('utf-8', 'windows-1251', array(
      $str => $str,
    ));
    $cp1251Hex = 'cff0e8e2e5f2';

    $this->assertEquals($cp1251Hex, bin2hex(key($cp1251)));
    $this->assertEquals($cp1251Hex, bin2hex(reset($cp1251)));
  }
  public function testStaticIconvObject()
  {
    $str = 'Привет';
    $obj = new stdClass;
    $obj->$str = $str;
    $cp1251 = MedInTech_Convertor_Charset::iconv('utf-8', 'windows-1251', $obj);
    $cp1251Hex = 'cff0e8e2e5f2';

    $this->assertEquals($cp1251Hex, bin2hex(key($cp1251)));
    $this->assertEquals($cp1251Hex, bin2hex(reset($cp1251)));
  }

  public function testClass()
  {
    $iconv = new MedInTech_Convertor_Charset();
    $str = 'Привет';
    $cp1251Hex = 'cff0e8e2e5f2';
    $encoded = $iconv->encode($str);
    $this->assertEquals($cp1251Hex, bin2hex($encoded));
    $this->assertEquals($str, $iconv->decode($encoded));

    $this->assertEquals(2, $iconv->encode(2));
    $this->assertEquals(2, $iconv->decode(2));
  }

  public function testFuncAbsence()
  {
    $iconv = new MedInTech_Convertor_Charset();
    $str = 'Привет';
    $cp1251Hex = 'cff0e8e2e5f2';
    $encoded = $iconv->encode($str);
    MedInTech_Convertor_Charset::$_DONTUSEICONV = true;
    $this->assertEquals($cp1251Hex, bin2hex($encoded));
    $this->assertEquals($str, $iconv->decode($encoded));
    MedInTech_Convertor_Charset::$_DONTUSEMBCONVERT = true;
    try {
      $iconv->decode($encoded);
      $this->fail('Expected warning was not triggered');
    } catch (Warning $warn) {
      $this->assertTrue(true, 'Expected warning was triggered');
    }
  }
}