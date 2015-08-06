<?php namespace FutureEd\Http\Requests\Api;


class ImageRequest extends ApiRequest {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		switch($this->method()) {
			case 'POST':
				switch ($this->route()->getName()) {
					case 'api.v1.image.delete':
						return [
							'delete_file' => 'required'
						];

						break;
				}

				break;

		}
	}

}
