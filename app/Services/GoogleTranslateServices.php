<?php namespace FutureEd\Services;


use Curl\Curl;
use FutureEd\Models\Traits\LoggerTrait;

class GoogleTranslateServices {

	use LoggerTrait;

	protected $target;

	protected $source;

	protected $google_api_key;

	public function __construct(){
		$this->curl = new Curl();
		$this->google_api = config('futureed.google_translate_api');
		$this->setGoogleApiKey(config('futureed.google_api_key'));
		$this->setSource(config('translatable.fallback_locale'));
		$this->setTarget(config('translatable.fallback_locale'));
	}

	/**
	 * @return mixed
	 */
	public function getTarget() {
		return $this->target;
	}

	/**
	 * @param mixed $target
	 */
	public function setTarget($target = 'id') {
		$this->target = $target;
	}

	/**
	 * @return mixed
	 */
	public function getSource() {
		return $this->source;
	}

	/**
	 * @param mixed $source
	 */
	public function setSource($source = 'en') {
		$this->source = $source;
	}

	/**
	 * @return mixed
	 */
	public function getGoogleApiKey() {
		return $this->google_api_key;
	}

	/**
	 * @param mixed $google_api_key
	 */
	public function setGoogleApiKey($google_api_key) {
		$this->google_api_key = $google_api_key;
	}

	/**
	 * translate string from source to target
	 * @param $string
	 * @return bool
	 */
	public function translate($string){

		//build parameters
		$param = [
			'key' => $this->google_api_key,
			'source' => $this->getSource(),
			'target' => $this->getTarget(),
			'q' => $string
		];

		//curl request
		$this->curl->get($this->google_api . '?' . http_build_query($param));

		//check if error else return translation.
		if($this->curl->error){

			$this->errorLog('GOGGLE_TRANSLATE : '. $this->curl->error_code . '/ '. $this->curl->error_message
				. '/ ' . $this->curl->http_error_message);

			return false;

		} else {

			$data = json_decode($this->curl->response);

			return $data->data->translations[0]->translatedText;
		}
	}



}