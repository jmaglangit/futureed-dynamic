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

	//Phone Format
	'phone' => '/^[0-9()-]+$/',

	//confirmation_code
	'email_code' => '/^[0-9]{4}(\-[0-9]{4})?$/',

	//pixel value e.g. 1px,20px,300px used by wikipedia pixels.
	'pixel' => '/([0-9]*)px/',

	//http or https of wikipedia
	//TODO look for better regex
	'wikisite' => [
		'http://en.wikipedia.org/wiki/',
		'https://en.wikipedia.org/wiki/'
	],

	//accepts only numbers
	'numeric' => '/^[0-9]+$/',
];