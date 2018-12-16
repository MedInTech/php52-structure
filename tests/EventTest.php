<?php

use PHPUnit\Framework\TestCase;

class EventTest extends TestCase
{
  public function testSubPub()
  {
    $ee = new MedInTech_Event_Emitter();
    $cc = new CallCounter();
    $ee->on('init', array($cc, 'init'));
    $ee->emit('init', 'call 1');
    $ee->emit('init', 'call 2');
    $ee->off('init');
    $ee->emit('init', 'call 3');

    $calls = $cc->getCalls('init');
    $this->assertCount(2, $calls);
  }

  public function testOffById()
  {
    $ee = new MedInTech_Event_Emitter();
    $cc = new CallCounter();
    $id = $ee->on('init', array($cc, 'init'));
    $ee->on('init', array($cc, 'all_init'));
    $ee->emit('init', 'call 1');
    $ee->emit('init', 'call 2');
    $ee->off('init', $id);
    $ee->emit('init', 'call 3');

    $calls = $cc->getCalls('init');
    $this->assertCount(2, $calls);
    $calls = $cc->getCalls('all_init');
    $this->assertCount(3, $calls);
  }

  public function testOffByListener()
  {
    $ee = new MedInTech_Event_Emitter();
    $cc = new CallCounter();
    $listener1 = array($cc, 'init');
    $listener2 = array($cc, 'all_init');

    $ee->on('init', $listener1);
    $ee->on('init', $listener2);
    $ee->emit('init', 'call 1');
    $ee->emit('init', 'call 2');
    $ee->off('init', $listener1);
    $ee->emit('init', 'call 3');

    $calls = $cc->getCalls('init');
    $this->assertCount(2, $calls);
    $calls = $cc->getCalls('all_init');
    $this->assertCount(3, $calls);
  }
}

class CallCounter
{
  protected $counts = array();
  public function getCalls($method)
  {
    if (empty($this->counts[$method])) return array();

    return $this->counts[$method];
  }
  public function __call($method, $arguments)
  {
    if (!array_key_exists($method, $this->counts)) $this->counts[$method] = array();
    $this->counts[$method][] = $arguments;
  }
}