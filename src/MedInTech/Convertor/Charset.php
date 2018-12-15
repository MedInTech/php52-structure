<?php

class MedInTech_Convertor_Charset implements MedInTech_Convertor_Interface
{
  public static $_DONTUSEICONV = false; // for testing iconv absence
  public static $_DONTUSEMBCONVERT = false; // for testing mb_convert_encoding absence
  private $inCharset;
  private $outCharset;
  public function __construct($inCharset = 'utf-8', $outCharset = 'windows-1251')
  {
    $this->inCharset = $inCharset;
    $this->outCharset = $outCharset;
  }
  public function encode($data)
  {
    return $this->iconv($this->inCharset, $this->outCharset, $data);
  }
  public function decode($data)
  {
    return $this->iconv($this->outCharset, $this->inCharset, $data);
  }

  public static function iconv($in_charset, $out_charset, $data)
  {
    if (is_array($data)) {
      $result = array();
      foreach ($data as $k => $v) {
        $key = self::iconv($in_charset, $out_charset, $k);
        $result[$key] = self::iconv($in_charset, $out_charset, $v);
      }

      return $result;
    } elseif (is_object($data)) {
      $result = new stdClass;
      foreach ($data as $k => $v) {
        $key = self::iconv($in_charset, $out_charset, $k);
        $result->$key = self::iconv($in_charset, $out_charset, $v);
      }

      return $result;
    } elseif (is_string($data)) {
      if (function_exists('iconv') && empty(self::$_DONTUSEICONV)) {
        return iconv($in_charset, $out_charset, $data);
      }
      if (function_exists('mb_convert_encoding') && empty(self::$_DONTUSEMBCONVERT)) {
        return mb_convert_encoding($data, $out_charset, $in_charset);
      }
      trigger_error('Neither the iconv nor the mbstring is installed', E_USER_WARNING);
    }

    return $data;
  }
}
