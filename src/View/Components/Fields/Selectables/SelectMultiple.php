<?php

namespace Styde\Form\View\Components\Fields\Selectables;

use Illuminate\Config\Repository as Config;
use Illuminate\Support\Collection;
use Styde\Form\Support\CurrentModel;
use Styde\Form\View\Components\Field;

class SelectMultiple extends Field
{
    /** @var array */
    public $options;

    /**
     * SelectMultiple constructor.
     *
     * @param Config $config
     * @param CurrentModel $currentModel
     * @param string $name
     * @param array $options
     * @param string|null $id
     * @param string|null $label
     * @param array|null $value
     * @param string|null $help
     */
    public function __construct(Config $config, CurrentModel $currentModel, string $name, array $options = [], string $id = null, string $label = null, array $value = null, string $help = null)
    {
        $this->options = $options;

        parent::__construct($config, $currentModel, $name, $id, $label, $value, $help);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('styde-form::fields.selectables.select-multiple');
    }

    /**
     * Returns selected attribute
     *
     * @param string $key
     * @param bool $hasErrors
     * @return string
     */
    public function isSelected(string $key, bool $hasErrors = false)
    {
        if (in_array($key, old($this->cleanName, []))) {
            return ' selected';
        }

        if (!$hasErrors) {
            if ($this->value instanceof Collection) {
                if ($this->value->contains($key)) {
                    return ' selected';
                }
            }

            if (is_array($this->value)) {
                if (in_array($key, $this->value)) {
                    return ' selected';
                }
            }
        }

        return '';
    }
}
