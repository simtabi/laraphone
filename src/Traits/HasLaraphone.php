<?php

namespace Simtabi\Laraphone\Traits;

trait HasLaraphone
{

    public function refreshesLaraphoneInstance()
    {
        $this->dispatchBrowserEvent('telDOMChanged');
    }

}