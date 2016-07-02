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
     * @return mixed
     */
    public function update($args = null);
}