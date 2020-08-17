<?php

class UnholyFactory {

    private array $_absorbFighters = [];
    private array $_types = [];

    public function absorb(object $person) {
        if (! $person instanceof Fighter) {
            echo '(Factory can\'t absorb this, it\'s not a fighter)' . "\n";
            return;
        }

        $type = $person->getType();
        if (in_array($type, $this->_types)) {
            echo '(Factory already absorbed a fighter of type ' . $type . ')' . "\n";
            return;
        }
        $this->_absorbFighters[$type] = $person;
        $this->_types[] = $type;
        echo '(Factory absorbed a fighter of type ' . $type . ')' . "\n";
    }

    public function fabricate(string $fighter): ?Fighter {
        if (!in_array($fighter, $this->_types)) {
            echo '(Factory hasn\'t absorbed any fighter of type ' . $fighter . ')' . "\n";
            return NULL;
        }
        echo '(Factory fabricates a fighter of type ' . $fighter . ')' . "\n";
        $ret = $this->_absorbFighters[$fighter];
        return $ret;
    }
}