<?php

namespace stubzero\EventEmitter;

/**
 * Class InterfaceObserver
 * @package stubzero\EventEmitter
 * @author robotomize@gmail.com
 */
interface InterfaceObserver
{
    /**
     * @param null $args
     */
    public function update($args = null);
}