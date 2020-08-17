<?php

abstract class Fighter {

    private string $_type;

    public function __construct(string $type) {
        $this->_type = $type;
    }

    public function getType() {
        return $this->_type;
    }

    abstract public function fight($target);
}
