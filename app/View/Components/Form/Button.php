<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Button extends Component
{
    public $class;

    public $text;

    /**
     * @var string
     */
    public $textProgress;

    /**
     * @var null
     */
    public $id;

    /**
     * @var array
     */
    public $dataset;
    public bool $disabled;

    /**
     * Create a new component instance.
     *
     * @param string $class
     * @param string $text
     * @param string $textProgress
     * @param null $id
     * @param array $dataset
     * @param bool $disabled
     */
    public function __construct(string $class = 'btn-bank', string $text = 'Valider', string $textProgress = 'Veuillez patientez...', $id = null, array $dataset = [], bool $disabled = false)
    {
        //
        $this->class = $class;
        $this->text = $text;
        $this->textProgress = $textProgress;
        $this->id = $id;
        $this->dataset = $dataset;
        $this->disabled = $disabled;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.button');
    }
}
