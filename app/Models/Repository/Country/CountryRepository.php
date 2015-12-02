<?php
namespace FutureEd\Models\Repository\Country;


use Webpatser\Countries\Countries;

class CountryRepository implements CountryRepositoryInterface{

	/**
     * Get list of countries.
     * @return mixed
     */
    public function getCountries(){

        return Countries::select(
            'id',
            'name',
            'full_name',
            'capital',
            'country_code'
        )
            ->orderBy('name','ASC')
            ->get()
            ->toArray();
    }

	/**
     * Get Country data
     * @param $id
     * @return mixed
     */
    public function getCountry($id){

        return Countries::select(
            'id',
            'name',
            'full_name',
            'capital',
            'country_code'
        )->where('id',$id)
            ->get()
            ->toArray();
    }

	/**
     * Get country code by iso_3166_2
     * @param $iso2
     * @return mixed
     */
    public function getCountryCodeByISO2($iso2){

        return Countries::select('id')
            ->where('iso_3166_2',strtoupper($iso2))
            ->get();
    }
}