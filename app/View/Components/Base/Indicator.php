<?php

namespace App\View\Components\Base;

use Illuminate\View\Component;

class Indicator extends Component
{
    public $text;
    /**
     * @var bool
     */
    public $textOnly;

    /**
     * Create a new component instance.
     * @param string $text
     * @param bool $textOnly
     */
    public function __construct($text = 'Veuillez patienter...', $textOnly = false)
    {
        //
        $this->text = $text;
        $this->textOnly = $textOnly;
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
