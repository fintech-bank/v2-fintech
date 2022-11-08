<?php

namespace App\View\Components\Base;

use Illuminate\View\Component;

class Icon extends Component
{
    public $icon;
    public string $size;
    public string $color;
    public bool $margin;

    /**
     * Create a new component instance.
     *
     * @param $icon
     * @param string $size
     * @param string $color
     * @param bool $margin
     */
    public function __construct($icon, $size = 'fs-3', $color = 'black', $margin = true)
    {
        //
        $this->icon = $icon;
        $this->size = $size;
        $this->color = $color;
        $this->margin = $margin;
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
