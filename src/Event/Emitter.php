<?php

class MedInTech_Event_Emitter implements MedInTech_Event_IEmitter
{
  protected $listeners = array();

  public function on($eventName, $listener)
  {
    if (!is_callable($listener)) return false;
    if (empty($this->listeners[$eventName])) $this->listeners[$eventName] = array();
    $this->listeners[$eventName][] = $listener;

    end($this->listeners[$eventName]);
    $index = key($this->listeners[$eventName]);
    reset($this->listeners[$eventName]);

    return $index;
  }
  public function off($eventName, $listener = null)
  {
    if (!array_key_exists($eventName, $this->listeners)) return null;
    if (is_null($listener)) { // off all listeners
      unset($this->listeners[$eventName]);
    } elseif (is_scalar($listener)) { // by identifier
      unset($this->listeners[$eventName][$listener]);
    } elseif (is_callable($listener)) { // by listener itself
      $index = array_search($listener, $this->listeners[$eventName]);
      if ($index !== false) return $this->off($eventName, $index);
    }

    return null;
  }
  public function emit($eventName, $data = null)
  {
    if (!array_key_exists($eventName, $this->listeners)) return null;
    foreach ($this->listeners[$eventName] as $listener) {
      if (!is_callable($listener)) continue;
      call_user_func($listener, $data, $eventName);
    }
  }
}
