<?php

namespace FutureEd\Services;


class PasswordServices {


	public function checkPassword($password){

			$valid = true;

		 if (!preg_match("#[0-9]+#", $password)){
                
                $valid = false;
         }

         if(!preg_match("#[a-z]+#", $password)){

                $valid = false;

         }

         if(!preg_match("#[A-Z]+#", $password)){

                $valid = false;
         }

         if(!preg_match("#[\W ]+#", $password)){

                $valid = false;
         }


        //to do put min to config
         if(strlen($password) <8){

         		$valid = false;
         }

        //to do put max to config
         if(strlen($password) >32){

         		$valid = false;
         }

         return $valid;   

	}

}