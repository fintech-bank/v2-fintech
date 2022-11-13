<?php

namespace App\View\Components\Base;

use Illuminate\View\Component;

class Indicator extends Component
{
    public bool $textOnly;
    /**
     * @var null
     */
    public $text;

    /**
     * Create a new component instance.
     *
     * @param bool $textOnly
     * @param null $text
     */
    public function __construct($textOnly = true, $text = null)
    {
        //
        $this->textOnly = $textOnly;
        $this->text = $text;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.base.indicator');
    }
}
