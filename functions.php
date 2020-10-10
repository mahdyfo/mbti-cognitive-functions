<?php

function get_input() {
	$handle = fopen ("php://stdin","r");
	$line = fgets($handle);
	fclose($handle);
	return strtolower(trim($line));
}

function is_valid($input) {
	if(strlen($input) == 4) { // 4 Char
		if( ($input[0] == 'i' || $input[0] == 'e') && // EXXX or IXXX
			($input[1] == 'n' || $input[1] == 's') && // XNXX or XSXX
			($input[2] == 't' || $input[2] == 'f') && // XXTX or XXFX
			($input[3] == 'j' || $input[3] == 'p')    // XXXJ or XXXP
		) {
			return true;
		}
	}
	
	return false;
}

function get_opposite($function) {
	switch ($function) {
		case 'i': return 'e'; break;
		case 'e': return 'i'; break;
		case 'n': return 's'; break;
		case 's': return 'n'; break;
		case 't': return 'f'; break;
		case 'f': return 't'; break;
		case 'j': return 'p'; break;
		case 'p': return 'j'; break;
		default: return false;
	}
}

// for example opposite of ['n', 'i'] is ['s', 'e']
function get_opposite_from_array($array_function) {
	return [get_opposite($array_function[0]), get_opposite($array_function[1])];
}

// for example opposite of ['n', 'i'] is ['n', 'e']
function get_2nd_opposite_from_array($array_function) {
	return [$array_function[0], get_opposite($array_function[1])];
}

function get_first_function ($type, $order) {
	
	if( $order == 0 ) {
		// N/S Dom
		return [$type[1], $type[0]];
	}else{
		// T/F Dom
		return [$type[2], $type[0]];
	}
}

function get_second_function ($type, $order) {
	
	if( $order == 0 ) {
		// T/F Aux
		return [$type[2], get_opposite($type[0])];
	}else{
		// N/S Aux
		return [$type[1], get_opposite($type[0])];
	}
}

function get_cognitive_functions($type) {
	$functions = [];
	
	// 0: normal order / 1: reverse order. (ixxj and exxp are normal. ixxp and exxj are reverse)
	$order = ( ($type[0] == 'i' && $type[3] == 'j') || ($type[0] == 'e' && $type[3] == 'p') ) ? 0 : 1;
	
	$functions[0] = get_first_function ($type, $order);
	$functions[1] = get_second_function($type, $order);
	$functions[2] = get_opposite_from_array($functions[1]); // 3rd function is opposite of 2nd
	$functions[3] = get_opposite_from_array($functions[0]); // 4th function is opposite of 1st
	$functions[4] = get_2nd_opposite_from_array($functions[0]); // 5th function is opposite of 1st but only 2nd param
	$functions[5] = get_2nd_opposite_from_array($functions[1]); // 6th function is opposite of 2nd but only 2nd param
	$functions[6] = get_2nd_opposite_from_array($functions[2]); // 7th function is opposite of 3rd but only 2nd param
	$functions[7] = get_2nd_opposite_from_array($functions[3]); // 8th function is opposite of 4th but only 2nd param
	
	return $functions;
}