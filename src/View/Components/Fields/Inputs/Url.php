<?php

namespace Styde\Form\View\Components\Fields\Inputs;

class Url extends Input
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('styde-form::fields.inputs.url');
    }
}
