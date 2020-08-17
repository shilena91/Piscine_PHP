<?php

require_once 'Color.class.php';

class Vertex {

    static $verbose = false;

    static function doc(): string {
        return file_get_contents(get_class() . '.doc.txt');
    }

    private $_x = 0;
    private $_y = 0;
    private $_z = 0;
    private $_w = 1.0;
    private $_color;

    public function __construct(array $input) {
        $keys = array_keys($input);

        $this->_x = floatval($input['x']);
        $this->_y = floatval(($input['y']));
        $this->_z = floatval($input['z']);

        if (in_array('w', $keys))
            $this->_w = floatval($input['w']);
        if (in_array('color', $keys))
            $this->_color = $input['color'];
        else
            $this->_color = new Color(['red' => 255, 'green' => 255, 'blue' => 255]);
        
        $this->_verboseConstruct();
        return $this;
    }

    public function __destruct() {
        $this->_verboseDestruct();
    }

    private function _verboseConstruct() {
        if (Vertex::$verbose)
            echo $this->__toString() . ' constructed' . "\n";
    }

    private function _verboseDestruct() {
        if (Vertex::$verbose)
            echo $this->__toString() . ' destructed' . "\n";
    }

    public function __toString(): string {
        $ret = sprintf(
            'Vertex( x: %.02f, y: %.02f, z: %.02f, w: %.02f',
            $this->_x,
            $this->_y,
            $this->_z,
            $this->_w
        );

        if (Vertex::$verbose)
            $ret .= ', ' . $this->_color->__toString();

        $ret .= ' )';
        return $ret;
    }

    public function getX(): float {
        return $this->_x;
    }

    public function getY(): float {
        return $this->_y;
    }

    public function getZ(): float {
        return $this->_z;
    }

    public function getW(): float {
        return $this->_w;
    }

    public function setX(float $val): Vertex {
        $this->_x = $val;
        return $this;
    }

    public function setY(float $val): Vertex {
        $this->_y = $val;
        return $this;
    }

    public function setZ(float $val): Vertex {
        $this->_z = $val;
        return $this;
    }

    public function setW(float $val): Vertex {
        $this->_w = $val;
        return $this;
    }
}
