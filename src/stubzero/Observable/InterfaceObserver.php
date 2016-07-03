<?php

namespace stubzero\Observable;

/**
 * Class InterfaceObserver
 * @package stubzero\Observable
 * @author robotomize@gmail.com
 */
interface InterfaceObserver
{
    /**
     * @param null $args
     */
    public function update($args = null);
}