<?php

namespace App\View\Components\Base;

use Illuminate\View\Component;

class Icon extends Component
{
    public $icon;
    public string $size;
    public string $margin;
    public string $color;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($icon, $size = 'fs-2', $margin = 'me-2', $color = 'primary')
    {
        //
        $this->icon = $icon;
        $this->size = $size;
        $this->margin = $margin;
        $this->color = $color;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.base.icon');
    }
}
