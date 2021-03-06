<?php

namespace Styde\Form\View\Components;

use Illuminate\Config\Repository as Config;
use Illuminate\Support\Collection;
use Illuminate\View\Component;
use Styde\Form\Support\CurrentModel;

abstract class Field extends Component
{
    /** @var Config */
    protected $config;

    /** @var CurrentModel */
    protected $currentModel;

    /** @var string Input name sanitized */
    public $cleanName;

    /** @var string Input name */
    public $name;

    /** @var string Input id */
    public $id;

    /** @var string Input label */
    public $label;

    /** @var string|array|Collection|null Input value */
    public $value;

    /** @var string|null Input help */
    public $help;

    /**
     * Field constructor.
     *
     * @param Config $config
     * @param CurrentModel $currentModel
     * @param string $name
     * @param string|null $id
     * @param string|null $label
     * @param string|array|null $value
     * @param string|null $help
     */
    public function __construct(Config $config, CurrentModel $currentModel, string $name, string $id = null, string $label = null, $value = null, string $help = null)
    {
        $this->config = $config;
        $this->currentModel = $currentModel;
        $this->name = $name;
        $this->cleanName = $this->cleanName($name);
        $this->label = $this->label($label);
        $this->value = $this->value($value);
        $this->id = $this->id($id);
        $this->help = $help;
    }

    /**
     * Returns the highlight of required and optional if they are active
     *
     * @return string|null
     */
    public function highlight()
    {
        if ($this->config->get('form.highlights_requirement') === 'required' && $this->isRequired()) {
            return __('styde-form::field.required');
        }

        if ($this->config->get('form.highlights_requirement') === 'optional' && !$this->isRequired()) {
            return __('styde-form::field.optional');
        }

        return null;
    }

    /**
     * Check if the field is required
     *
     * @return bool
     */
    public function isRequired()
    {
        return !is_null($this->attributes->get('required'));
    }

    /**
     * Return the name without brackets for a multi select
     *
     * @param string $name
     * @return string
     */
    protected function cleanName(string $name)
    {
        return str_replace('[]', '', $name);
    }

    /**
     * Gets the id for the input, which can be passed as an
     * attribute or obtained from the input name
     *
     * @param string|null $id
     * @return string
     */
    protected function id(?string $id)
    {
        return $id ? $id : sprintf('field-%s', $this->cleanName);
    }

    /**
     * Gets the label for the input, which can be passed as an
     * attribute or obtained from the input name
     *
     * @param string|null $label
     * @return string
     */
    protected function label(?string $label)
    {
        return $label ? $label : ucfirst(str_replace('_', ' ', $this->cleanName));
    }

    /**
     * Obtains the value of the input, which can be passed as an attribute to the component
     * or obtained from the form model, both checked in the old function.
     *
     * @param string|array|Collection|null $value
     * @return string|null
     */
    protected function value($value)
    {
        $model = $this->currentModel->get();

        if ($value) {
            return old($this->cleanName, $value);
        }

        if (is_object($model)) {
            if (!in_array($this->cleanName, $model->getHidden())) {
                return old($this->cleanName, $model->{$this->cleanName});
            }
        }

        return old($this->cleanName);
    }
}
