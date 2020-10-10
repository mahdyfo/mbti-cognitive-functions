<?php
require_once('functions.php');

echo 'Enter your type: ';

$type = get_input();
while(!is_valid($type)) {
	echo "Invalid type.\n\nEnter again: ";
	$type = get_input();
}

var_dump(get_cognitive_functions($type));