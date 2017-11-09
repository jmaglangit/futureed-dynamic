<?php

namespace FutureEd\Services;


class RegistrationTokenServices {

	protected $key ;

	public function getKey(){

		$this->key = config('token.key');
		return $this->key;
	}

	/**
	 * Get Registration token
	 * @param $data
	 * @return string
	 */
	public function getRegistrationToken($data){

		return hash_hmac('sha1', $data ,$this->key);

	}

}