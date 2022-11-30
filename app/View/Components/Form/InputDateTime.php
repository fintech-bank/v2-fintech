<?php

namespace App\View\Components\Form;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class InputDateTime extends Component
{
    public $name;
    public $label;
    /**
     * @var false
     */
    public bool $required;
    /**
     * @var null
     */
    public $placeholder;
    /**
     * @var null
     */
    public $class;

    /**
     * @param $name
     * @param $label
     * @param $required
     * @param $placeholder
     * @param $class
     */
    public function __construct($name, $label, $required = false, $placeholder = null, $class = null)
    {
        $this->name = $name;
        $this->label = $label;
        $this->required = $required;
        $this->placeholder = $placeholder;
        $this->class = $class;
    }

    public function render(): View
    {
        return view('components.input-date-time');
    }
}
