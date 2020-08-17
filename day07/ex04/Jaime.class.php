<?php

class Jaime extends Lannister {

    public function sleepwith(object $person) {
        if ($person instanceof Cersei) {
            echo 'With pleasure, but only in a towel in Winterfell, then.' . "\n";
            return;
        }
        parent::sleepWith($person);
    }
}
