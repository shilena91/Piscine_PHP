<?php

class House {
    
    public function introduce() {
        $str = sprintf(
            'House %s of %s : "%s"' . "\n",
            $this->getHouseName(),
            $this->getHouseSeat(),
            $this->getHouseMotto()
          );
          echo $str;
    }
}
