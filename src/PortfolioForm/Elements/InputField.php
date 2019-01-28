<?php

namespace bcdbuddy\PortfolioForm\Elements;

class InputField extends Input{

    protected $label;
    protected $label_string;
    protected $addons = [];
    protected $helperBloc;
    protected $addonClass;

    function __construct($label, $name)
    {
        parent::__construct($name);
        $this->label = new Label($label);
        $this->label->attribute("for", $name);
        $this->label_string = $label;
        $this->helperBloc = new HelperBloc();
        $this->addonClass = [];
    }

    public function render()
    {
        $result = '<div class="form-field '. implode(" ", $this->addonClass) .'">';
        foreach ($this->addons as $addon) {
            $result .= $addon;
        }
        $result .= $this->label;
        $result .= parent::render();
        $result .= $this->helperBloc;
        $result .= '</div>';
        return $result;
    }

    public function addon ($addon) {
        $this->addons[] = $addon;
    }


    public function icon ($icon_name, $class=false) {
        $icon = new MaterialIcon($icon_name);
        if ($class) {
            $icon->addClass($class);
        }
        $icon->addClass("prefix");
        $this->addon($icon);
        return $this;
    }


    public function getLabel()
    {
        return $this->label;
    }


    public function getHelperBloc () {
        return $this->helperBloc;
    }

    public function parentClass ($class)
    {
        $this->addonClass[] = $class;
        return $this;
    }
}