<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Webpatser\Countries\Countries;

class CountryController extends ApiController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
        return $this->respondWithData($this->country->getCountries());

	}

    public function show($id){

        $country = $this->country->getCountry($id);

        if(!$country){

            return $this->respondErrorMessage(2005);
        }

        return $this->respondWithData($country);

    }



}
