<?php

interface MedInTech_Event_IEmitter
{
  /**
   * Subscribe $listener onto event $eventName
   */
  public function on($eventName, $listener);
  /**
   * Unsubscribe listener, all, by listener, or by listenerId returned by on method
   */
  public function off($eventName, $listener = null);
  /**
   * Emit event $eventName with $data to all subscribed listeners
   */
  public function emit($eventName, $data = null);
}