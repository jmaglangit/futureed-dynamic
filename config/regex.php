<?php
/**
 * Regular Expression
 */
return [

	//Name, accepts dash, enye (ñ), space in between characters.
	'name' => '/^([a-z][a-zñ\-\x20]*[a-z])+$/i',

	//Name, accepts dash, enye (ñ), space in between characters and numbers.
	'name_numeric' => '/^([a-z0-9][a-z0-9ñ\-\x20]*[a-z0-9])+$/i',

	//Zip code
	'zip_code' => '/^[0-9]{5}(\-[0-9]{4})?$/',
];