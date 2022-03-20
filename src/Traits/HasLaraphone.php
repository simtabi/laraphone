<?php

namespace Simtabi\Laraphone\Traits;

trait HasLaraphone
{

    public function hydratesLaraphone()
    {
        $this->dispatchBrowserEvent('telDOMChanged');
    }

}