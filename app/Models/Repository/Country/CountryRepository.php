<?php
namespace FutureEd\Models\Repository\Country;

use Illuminate\Support\Facades\DB;
use Webpatser\Countries\Countries;

class CountryRepository implements CountryRepositoryInterface{

	/**
	 * Get list of countries.
	 * @return mixed
	 */
	public function getCountries(){
		DB::beginTransaction();

		try{
			$response = Countries::select(
							'id',
							'name',
							'full_name',
							'capital',
							'country_code')
							->orderBy(DB::raw("CASE WHEN name = 'United States' THEN 1 ELSE 2 END, name"))
							->get()
							->toArray();
			
		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get Country data
	 * @param $id
	 * @return mixed
	 */
	public function getCountry($id){
		DB::beginTransaction();

		try{
			$response = Countries::select(
							'id',
							'name',
							'full_name',
							'capital',
							'country_code')
							->where('id',$id)
							->get()
							->toArray();

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get country code by iso_3166_2
	 * @param $iso2
	 * @return mixed
	 */
	public function getCountryCodeByISO2($iso2){
		DB::beginTransaction();

		try{
			$response = Countries::select('id')
							->where('iso_3166_2',strtoupper($iso2))
							->get();

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}
}