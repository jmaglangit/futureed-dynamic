<?php
namespace FutureEd\Models\Repository\Country;


interface CountryRepositoryInterface {

    public function getCountries();

    public function getCountry($id);

    public function getCountryCodeByISO2($iso2);
}