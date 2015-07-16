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
	'zip_code' => '/^[a-zA-Z0-9]+(\-[a-zA-Z0-9]+)*?$/',

	//State and City
	'state_city' => '/^[-\pL\s]+$/u',
];