<?php

namespace Styde\Form\View\Components\Fields\Selectables;

use Illuminate\Config\Repository as Config;
use Illuminate\Support\Collection;
use Styde\Form\Support\CurrentModel;
use Styde\Form\View\Components\Field;

class Checkbox extends Field
{
    /** @var string */
    public $option;

    /**
     * Checkbox constructor.
     *
     * @param Config $config
     * @param CurrentModel $currentModel
     * @param string $name
     * @param string $option
     * @param string|null $id
     * @param string|null $label
     * @param string|null $value
     * @param string|null $help
     */
    public function __construct(Config $config, CurrentModel $currentModel, string $name, string $option = 'true', string $id = null, string $label = null, string $value = null, string $help = null)
    {
        $this->option = $option;

        parent::__construct($config, $currentModel, $name, $id, $label, $value, $help);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('styde-form::fields.selectables.checkbox');
    }

    /**
     * Returns checked attribute
     *
     * @param string $key
     * @param bool $hasErrors
     * @return string
     */
    public function isChecked(string $key, bool $hasErrors = false)
    {
        if (!$hasErrors) {
            return (!is_object($this->value) && $this->value) || (string)$key == (string)$this->value ? ' checked' : '';
        } else {
            return $key == old($this->cleanName) ? ' checked' : '';
        }
    }
}
