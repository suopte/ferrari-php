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

require_once 'complex.php';

function depressedFerrari($alpha, $beta, $gamma) {
	$P = -$alpha * $alpha / 12 - $gamma;
	$Q = -$alpha * $alpha * $alpha / 108 + $alpha * $gamma / 3 - $beta * $beta / 8;
	$R = sqrtExt($Q * $Q / 4 + $P * $P * $P / 27, true)->sub($Q / 2);
	$U = $R->pow(1/3);
	
	$y = ($U->equals(0.0)) ? ($U->sub(5/6 * $alpha)->sub(pow($Q, 1/3))) : ($U->sub(5/6 * $alpha)->sub(complex($P)->div($U->mul(3))));

	$W = $y->mul(2)->add($alpha)->sqrt();
	
	$D1 = $y->mul(2)->add(3 * $alpha)->add(complex(2 * $beta)->div($W))->neg();
	$D2 = $y->mul(2)->add(3 * $alpha)->sub(complex(2 * $beta)->div($W))->neg();
	
	$u = array();
	$u[] = $W->add($D1->sqrt())->div(2);
	$u[] = $W->add($D2->sqrt())->div(2)->neg();
	$u[] = $W->sub($D1->sqrt())->div(2);
	$u[] = $W->sub($D2->sqrt())->div(2)->neg();

	return $u;
}

function generalFerrari($A, $B, $C, $D, $E) {
	$A2 = $A * $A;
	$A3 = $A2 * $A;
	$B2 = $B * $B;
	$B3 = $B2 * $B;
	$alpha = $C / $A - 3 * $B2 / 8 / $A2;
	$beta = $B3 / 8 / $A3 - $B * $C / 2 / $A2 + $D / $A;
	$gamma = $C *  $B2 / 16 / $A3 - 3 * $B3 * $B / (256 * $A3 * $A) - $B * $D / 4 / $A2 + $E / $A;
	
	$u = depressedFerrari($alpha, $beta, $gamma);
	
	$x = array();
	$t = $B / 4 / $A;
	$x[] = $u[0]->sub($t);
	$x[] = $u[1]->sub($t);
	$x[] = $u[2]->sub($t);
	$x[] = $u[3]->sub($t);
	
	return $x;
}
?>
