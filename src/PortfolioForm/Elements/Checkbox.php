<?php

namespace bcdbuddy\PortfolioForm\Elements;

class Checkbox extends InputField
{
    protected $attributes = [
        'type' => 'checkbox',
    ];
    protected $checked;
    protected $oldValue;
    protected $checkbox_class = "form-field-checkbox";

    public function __construct($label, $name, $value = 1)
    {
        parent::__construct($label, $name);
        if ($value) {
            $this->attribute("checked", "checked");
        }

        $this->setValue($value);
    }

    public function setOldValue($oldValue)
    {
        $this->oldValue = $oldValue;
    }

    public function unsetOldValue()
    {
        $this->oldValue = null;
    }

    public function defaultToChecked()
    {
        if (! isset($this->checked) && is_null($this->oldValue)) {
            $this->check();
        }

        return $this;
    }

    public function defaultToUnchecked()
    {
        if (! isset($this->checked) && is_null($this->oldValue)) {
            $this->uncheck();
        }

        return $this;
    }

    public function defaultCheckedState($state)
    {
        $state ? $this->defaultToChecked() : $this->defaultToUnchecked();

        return $this;
    }

    public function check()
    {
        $this->unsetOldValue();
        $this->setChecked(true);

        return $this;
    }

    public function uncheck()
    {
        $this->unsetOldValue();
        $this->setChecked(false);

        return $this;
    }

    protected function setChecked($checked = true)
    {
        $this->checked = $checked;
        $this->removeAttribute('checked');

        if ($checked) {
            $this->setAttribute('checked', 'checked');
        }
    }

    protected function checkBinding()
    {
        $currentValue = (string) $this->getAttribute('value');

        $oldValue = $this->oldValue;
        $oldValue = is_array($oldValue) ? $oldValue : [$oldValue];
        $oldValue = array_map('strval', $oldValue);

        if (in_array($currentValue, $oldValue)) {
            return $this->check();
        }
    }

    public function render () {
        return implode('', [
            sprintf('<p class="%s">', $this->checkbox_class),
                sprintf('<input %s/>', $this->renderAttributes()),
                    sprintf('<label for="%s">', $this->attributes['name']),
                        '<span>',
                            $this->label_string,
                        '</span>',
                    '</label>',
            '</p>'
        ]);
    }
}
