<?php

class NightsWatch {

    private array $fighters = [];

    public function recruit(object $person) {
        if ($person instanceof IFighter) {
            $this->fighters[] = $person;
        }
    }

    public function fight() {
        foreach ($this->fighters as $f) {
            $f->fight();
        }
    }
}
