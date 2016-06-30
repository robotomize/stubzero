<?php


namespace stubzero\EventEmitter;


trait Subject
{
    /**
     * @var array
     */
    private $observers = [];


    public function attach($observer)
    {
        $this->observers[] = $observer;
    }


    public function detach($observer)
    {
        $key = array_search($observer, $this->observers, true);

        if ($key) {
            unset($this->observers[$key]);
        }
    }

    public function notify()
    {
        foreach ($this->observers as $value) {
            $value->update($this);
        }
    }
}