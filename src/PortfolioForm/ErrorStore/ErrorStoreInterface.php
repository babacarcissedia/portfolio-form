<?php

namespace bcdbuddy\PortfolioForm\ErrorStore;

interface ErrorStoreInterface
{
    public function hasError($key);

    public function getError($key);
}
