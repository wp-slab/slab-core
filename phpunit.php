<?php

$files = [
	'./vendor/autoload.php',
	'../../../vendor/autoload.php',
];

foreach($files as $file) {
	if(is_file($file)) {
		include $file;
		break;
	}
}
