<?php
/* Copyright 2012 Bence Ágg, suopte
 * http://suopte.com/
 * 
 * Permission is hereby granted, free of charge, to any person obtaining 
 * a copy of this software and associated documentation files (the 
 * "Software"), to deal in the Software without restriction, including 
 * without limitation the rights to use, copy, modify, merge, publish, 
 * distribute, sublicense, and/or sell copies of the Software, and to 
 * permit persons to whom the Software is furnished to do so, subject to 
 * the following conditions:
 * 
 * The above copyright notice and this permission notice shall be 
 * included in all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, 
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF 
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND 
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE 
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION 
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION 
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

class teComplex {
	public $r;
	public $i;
	
	public function __construct($r, $i) {
		$this->r = $r;
		$this->i = $i;
	}
	
	public function toString() {
		if ($this->i == 0.0) {
			return $this->r;
		} elseif ($this->i < 0.0) {
			return $this->r . ' - ' . abs($this->i) . 'i';
		} else {
			return $this->r . ' + ' . $this->i . 'i';
		}
	}
	
	public function equals($num) {
		if (is_a($num, 'teComplex')) {
			return ($num->r == $this->r && $num->i == $this->i);
		} else {
			return (floatval($num) == $this->r && $this->i == 0.0);
		}
	}
	
	public function abs() {
		return sqrt($this->r * $this->r + $this->i * $this->i);
	}
	
	public function arg() {
		return atan2($this->i, $this->r);
	}
	
	public function neg() {
		return new teComplex(-$this->r, -$this->i);
	}
	
	public function conj() {
		return new teComplex($this->r, -$this->i);
	}
	
	public function inverse() {
		$denom = $this->r * $this->r + $this->i * $this->i;
		if ($denom == 0.0) {
			throw new Exception('Division by zero while inverting zero.');
		} else {
			return new teComplex($this->r / $denom, -$this->i / $denom);
		}
	}
	
	public function add($num) {
		if (is_a($num, 'teComplex'))
			return new teComplex($this->r + $num->r, $this->i + $num->i);
		else 
			return new teComplex($this->r + floatval($num), $this->i);
	}
	
	public function sub($num) {
		if (is_a($num, 'teComplex'))
			return new teComplex($this->r - $num->r, $this->i - $num->i);
		else 
			return new teComplex($this->r - floatval($num), $this->i);
	}
	
	public function mul($num) {
		if (is_a($num, 'teComplex')) {
			return new teComplex(
					$this->r * $num->r - $this->i * $num->i, 
					$this->i * $num->r + $this->r * $num->i);
		} else {
			$real = floatval($num);
			return new teComplex($this->r * $real, $this->i * $real); 
		}
	}
	
	public function div($num) {
		if (is_a($num, 'teComplex')) {
			$denom = $num->r * $num->r + $num->i * $num->i;
			if ($denom == 0.0) {
				throw new Exception('Division by zero');
			} else {
				return new teComplex(
						($this->r * $num->r + $this->i * $num->i) / $denom, 
						($this->i * $num->r - $this->r * $num->i) / $denom);
			}
		} else {
			$real = floatval($num);
			if ($real == 0.0) {
				throw new Exception('Division by zero');
			} else {
				return new teComplex($this->r / $real, $this->i / $real);
			}
		}
	}
	
	public function pow($num) {
		if ($this->r == 0.0 && $this->i = 0.0) {
			return new teComplex(0.0, 0.0);
		} else {
			$logabs = log($this->abs());
			$arg = $this->arg();
			if (is_a($num, 'teComplex')) {
				$pabs = exp($num->r * $logabs - $num->i * $arg);
				$parg = $num->i * $logabs + $num->r * $arg;
			} else {
				$real = floatval($num);
				$pabs = exp($real * $logabs);
				$parg = $real * $arg;
			}
			return new teComplex($pabs * cos($parg), $pabs * sin($parg));
		}
	}
	
	public function sqrt() {
		if ($this->r == 0.0 && $this->i == 0.0) {
			return new teComplex(0.0, 0.0);
		} else {
			$abs = $this->abs();
			if ($this->i < 0.0) {
				return new teComplex(sqrt(($abs + $this->r) / 2), -sqrt(($abs - $this->r) / 2));
			} else {
				return new teComplex(sqrt(($abs + $this->r) / 2), sqrt(($abs - $this->r) / 2));
			}
		}
	}
}

function sqrtExt($real, $forceComplex = false) {
	if ($real < 0.0) {
			return new teComplex(0.0, sqrt(-$real));
	} else {
		if ($forceComplex) {
			return new teComplex(sqrt($real), 0.0);
		} else {
			return sqrt($real);
		}
	}
}

function complex($r, $i = 0.0) {
	return new teComplex($r, $i);
}
?>