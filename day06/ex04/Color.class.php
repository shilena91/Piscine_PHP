<?php

class Color {

	static $verbose = false;

	static function doc(): string {
		return file_get_contents(get_class() . '.doc.txt');
	}

	public $red = 0;
	public $green = 0;
	public $blue = 0;

	public function __construct(array $input) {
		$keys = array_keys($input);
		if (in_array('rgb', $keys)) {
			$this->setRGB($input['rgb']);
			$this->_verboseConstruct();
			return $this;
		}

		$this->set($input);
		$this->_verboseConstruct();
		return $this;
	}

	public function __destruct() {
		$this->_verboseDestruct();
	}

	public function setRGB($rgb): Color {
		$rgb = intval($rgb, 0);
		$this->red = ($rgb & (0b111111110000000000000000)) >> 16;
		$this->green = ($rgb & (0b000000001111111100000000)) >> 8;
		$this->blue = $rgb & (0b000000000000000011111111);
		return $this;
	}

	public function set(array $input): Color {
		$keys = array_keys($input);
		if (in_array('red', $keys)) {
			$red = intval($input['red'], 0);
			$this->_setColorKeyed('red', $red);
		}
		if (in_array('green', $keys)) {
			$green = intval($input['green'], 0);
			$this->_setColorKeyed('green', $green);
		}
		if (in_array('blue', $keys)) {
			$blue = intval($input['blue'], 0);
			$this->_setColorKeyed('blue', $blue);
		}
		return $this;
	}

	private function _setColorKeyed(string $key, int $value): Color {
		$this->$key = $value & 0b11111111;
		return $this;
	}

	public function add(Color $that): Color {
		return new Color([
			'red' => $this->red + $that->red,
			'green' => $this->green + $that->green,
			'blue' => $this->blue + $that->blue
		]);
	}

	public function sub(Color $that): Color {
		return new Color([
			'red' => $this->red - $that->red,
			'green' => $this->green - $that->green,
			'blue' => $this->blue - $that->blue
		]);
	}

	public function mult($mult): Color {
		$mult = floatval($mult);
		return new Color([
			'red' => $this->red * $mult,
			'green' => $this->green * $mult,
			'blue' => $this->blue * $mult
		]);
	}

	private function _verboseConstruct() {
		if (Color::$verbose) {
			echo $this->__toString() . ' constructed.' . "\n";
		}
	}

	private function _verboseDestruct() {
		if (Color::$verbose) {
			echo $this->__toString() . ' destructed.' . "\n";
		}
	}

	public function __toString(): string {
		return sprintf(
			'Color( red: %3d, green: %3d, blue: %3d )',
			$this->red,
			$this->green,
			$this->blue
		);
	}
}
