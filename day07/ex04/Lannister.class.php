<?php

class Lannister {
    public function sleepWith(object $person) {
        if ($person instanceof Lannister) {
            echo 'Not even if I\'m drunk !' . "\n";
            return;
        }
        echo 'Let\'s do this.' . "\n";
    }
}
