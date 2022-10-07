<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class InputFile extends Component
{
    public $name;
    public $label;
    public $required;

    /**
     * Create a new component instance.
     *
     * @param $name
     * @param $label
     * @param $required
     */
    public function __construct($name, $label, $required)
    {
        //
        $this->name = $name;
        $this->label = $label;
        $this->required = $required;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.input-file');
    }
}
