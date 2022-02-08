<?php

namespace Simtabi\Laraphone\Views\Components;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TelInput extends Component
{
    public $id;
    public $name;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $id = null, string $name = 'phone')
    {
        $this->id   = $id;
        $this->name = $name;

        if (!$this->name) {
            $this->name = 'phone-' . uniqid();
        }
        if (!$this->id) {
            $this->id = $this->name;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Application|Factory|View
     */
    public function render()
    {
        return view('laraphone::components.laraphone');
    }
}
