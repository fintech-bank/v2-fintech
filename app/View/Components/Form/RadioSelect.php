<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class RadioSelect extends Component
{
    /**
     * Create a new component instance.
     *
     * @param string $name
     * @param string $label
     * @param string $labelContent
     * @param string $icon
     * @param string $value
     * @param bool $checked
     */
    public function __construct(public string $name, public string $label, public string $labelContent,public string $icon, public string $value, public bool $checked = false)
    {

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.radio-select');
    }
}
