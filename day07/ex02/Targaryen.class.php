<?php

class Targaryen {

    public function resistsFire() {
        return false;
    }

    function getBurned() {
        return !$this->resistsFire() ? "burns alive" : "emerges naked but unharmed";
    }
}
