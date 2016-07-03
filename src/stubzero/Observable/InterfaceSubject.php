<?php

namespace stubzero\Observable;

/**
 * Class InterfaceSubject
 * @package stubzero\Observable
 * @author robotomize@gmail.com
 */
interface InterfaceSubject
{
    /**
     * @param $observer
     */
    public function attach(InterfaceObserver $observer);

    /**
     * @param $observer
     */
    public function detach(InterfaceObserver $observer);

    /**
     * @param null $args
     */
    public function notify($args = null);
}