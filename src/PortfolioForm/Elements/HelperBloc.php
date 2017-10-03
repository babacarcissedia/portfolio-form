<?php

namespace bcdbuddy\PortfolioForm\Elements;

class HelperBloc extends Element {

    protected $content = "";

    public function render ()
    {
        return sprintf('<p%s>'. $this->content .'</p>', $this->renderAttributes());
    }


    public function content ($value) {
        $this->content = $value;
    }
}