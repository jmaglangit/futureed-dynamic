<?php
namespace FutureEd\Models\Repository\Country;


use Webpatser\Countries\Countries;

class CountryRepository implements CountryRepositoryInterface{

    public function getCountries(){

        return Countries::select(
            'id',
            'name',
            'full_name',
            'capital',
            'country_code'
        )->get()
            ->toArray();
    }

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
}