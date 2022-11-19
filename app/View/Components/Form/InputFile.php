<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class InputFile extends Component
{
    public $name;
    public $label;
    public string $required;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $label, $required = '')
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
