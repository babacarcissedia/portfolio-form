<?php

namespace bcdbuddy\PortfolioForm;

use bcdbuddy\PortfolioForm\Binding\BoundData;
use bcdbuddy\PortfolioForm\Elements\Button;
use bcdbuddy\PortfolioForm\Elements\Checkbox;
use bcdbuddy\PortfolioForm\Elements\Date;
use bcdbuddy\PortfolioForm\Elements\DateTimeLocal;
use bcdbuddy\PortfolioForm\Elements\Email;
use bcdbuddy\PortfolioForm\Elements\File;
use bcdbuddy\PortfolioForm\Elements\FormOpen;
use bcdbuddy\PortfolioForm\Elements\Hidden;
use bcdbuddy\PortfolioForm\Elements\InputField;
use bcdbuddy\PortfolioForm\Elements\Label;
use bcdbuddy\PortfolioForm\Elements\Number;
use bcdbuddy\PortfolioForm\Elements\Password;
use bcdbuddy\PortfolioForm\Elements\RadioButton;
use bcdbuddy\PortfolioForm\Elements\Select;
use bcdbuddy\PortfolioForm\Elements\Submit;
use bcdbuddy\PortfolioForm\Elements\SwitchCheckBox;
use bcdbuddy\PortfolioForm\Elements\Text;
use bcdbuddy\PortfolioForm\Elements\Tel;
use bcdbuddy\PortfolioForm\Elements\TextArea;
use bcdbuddy\PortfolioForm\ErrorStore\ErrorStoreInterface;
use bcdbuddy\PortfolioForm\OldInput\OldInputInterface;

class PortfolioForm
{
    protected $oldInput;

    protected $errorStore;

    protected $csrfToken;

    protected $boundData;

    public function setOldInputProvider(OldInputInterface $oldInputProvider)
    {
        $this->oldInput = $oldInputProvider;
    }

    public function setErrorStore(ErrorStoreInterface $errorStore)
    {
        $this->errorStore = $errorStore;
    }

    public function setToken($token)
    {
        $this->csrfToken = $token;
    }

    public function open()
    {
        $open = new FormOpen;

        if ($this->hasToken()) {
            $open->token($this->csrfToken);
        }

        return $open;
    }

    protected function hasToken()
    {
        return isset($this->csrfToken);
    }

    public function close()
    {
        $this->unbindData();

        return '</form>';
    }

    public function text($label, $name)
    {
        $text = new Text($label, $name);

        if (!is_null($value = $this->getValueFor($name))) {
            $text->value($value);
        }

        $this->renderErrorIfAny($text, $name);

        return $text;
    }

    public function tel($label, $name)
    {
        $text = new Tel($label, $name);

        if (!is_null($value = $this->getValueFor($name))) {
            $text->value($value);
        }

        $this->renderErrorIfAny($text, $name);

        return $text;
    }

    public function date($name)
    {
        $date = new Date($name);

        if (!is_null($value = $this->getValueFor($name))) {
            $date->value($value);
        }

        return $date;
    }

    public function datetime($label, $name)
    {
        $date = new DateTimeLocal($label, $name);

        if (!is_null($value = $this->getValueFor($name))) {
            $date->value($value);
        }

        return $date;
    }

    public function email($label, $name)
    {
        $email = new Email($label, $name);

        if (!is_null($value = $this->getValueFor($name))) {
            $email->value($value);
        }

        $this->renderErrorIfAny($email, $name);

        return $email;
    }

    public function hidden($name, $value = null)
    {
        $hidden = new Hidden($name);

        if (($value != null) or !is_null($value = $this->getValueFor($name))) {
            $hidden->value($value);
        }

        return $hidden;
    }

    public function textarea($label, $name)
    {
        $textarea = new TextArea($label, $name);

        if (!is_null($value = $this->getValueFor($name))) {
            $textarea->value($value);
        }

        return $textarea;
    }

    public function password($label, $name)
    {
        $password = new Password($label, $name);
        $this->renderErrorIfAny($password, $name);
        return $password;
    }

    public function checkbox($name, $value = 1)
    {
        $checkbox = new Checkbox($name, $value);

        $oldValue = $this->getValueFor($name);
        $checkbox->setOldValue($oldValue);
        $this->renderErrorIfAny($checkbox, $name);

        return $checkbox;
    }

    public function radio($label, $name, $value = null)
    {
        $radio = new RadioButton($label, $name, $value);

        $oldValue = $this->getValueFor($name);
        $radio->setOldValue($oldValue);
        $this->renderErrorIfAny($radio, $name);

        return $radio;
    }

    public function button($value)
    {
        return new Button($value);
    }

    public function submit($value = 'Submit', $class='')
    {
        $submit = new Submit($value);
        $submit->addClass($class);

        return $submit;
    }

    public function select($label, $name, $options = [], $icons = [])
    {
        $select = new Select($label, $name, $options, $icons);

        $selected = $this->getValueFor($name);
        $select->select($selected);
        $this->renderErrorIfAny($select, $name);

        return $select;
    }



    public function number($label, $name)
    {
        $text = new Number($label, $name);

        if (!is_null($value = $this->getValueFor($name))) {
            $text->value($value);
        }

        $this->renderErrorIfAny($text, $name);

        return $text;
    }


    public function phone ($label, $name)
    {
        $text = new Phone($label, $name);

        if (!is_null($value = $this->getValueFor($name))) {
            $text->value($value);
        }

        $this->renderErrorIfAny($text, $name);

        return $text;
    }

    public function label($label)
    {
        return new Label($label);
    }

    public function file($label, $name)
    {
        return new File($label, $name);
    }

    public function token()
    {
        $token = $this->hidden('_token');

        if (isset($this->csrfToken)) {
            $token->value($this->csrfToken);
        }

        return $token;
    }

    public function hasError($name)
    {
        if (! isset($this->errorStore)) {
            return false;
        }

        return $this->errorStore->hasError($name);
    }

    public function getError($name, $format = null)
    {
        if (! isset($this->errorStore)) {
            return null;
        }

        if (! $this->hasError($name)) {
            return '';
        }

        $message = $this->errorStore->getError($name);

        if ($format) {
            $message = str_replace(':message', $message, $format);
        }

        return $message;
    }

    public function bind($data)
    {
        $this->boundData = new BoundData($data);
    }

    public function getValueFor($name)
    {
        if ($this->hasOldInput()) {
            return $this->getOldInput($name);
        }

        if ($this->hasBoundData()) {
            return $this->getBoundValue($name, null);
        }

        return null;
    }

    protected function hasOldInput()
    {
        if (! isset($this->oldInput)) {
            return false;
        }

        return $this->oldInput->hasOldInput();
    }

    protected function getOldInput($name)
    {
        return $this->escape($this->oldInput->getOldInput($name));
    }

    protected function hasBoundData()
    {
        return isset($this->boundData);
    }

    protected function getBoundValue($name, $default)
    {
        return $this->escape($this->boundData->get($name, $default));
    }

    protected function escape($value)
    {
        if (! is_string($value)) {
            return $value;
        }

        return htmlentities($value, ENT_QUOTES, 'UTF-8');
    }

    protected function unbindData()
    {
        $this->boundData = null;
    }

    public function selectMonth($name)
    {
        $options = [
            "1" => "January",
            "2" => "February",
            "3" => "March",
            "4" => "April",
            "5" => "May",
            "6" => "June",
            "7" => "July",
            "8" => "August",
            "9" => "September",
            "10" => "October",
            "11" => "November",
            "12" => "December",
        ];

        return $this->select($name, $options);
    }


    public function switchCheckbox ($label, $name) {
        $switch = new SwitchCheckBox($label, $name);
        return $switch;
    }

    private function renderErrorIfAny(InputField $element, $name)
    {
        if ($this->hasError($name)) {
            $element->parentClass("with-error")->parentClass("has-focus");
            $element->getHelperBloc()->content($this->getError($name));

        }
    }
}
