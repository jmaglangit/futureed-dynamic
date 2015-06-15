<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Models\Repository\Client\ClientRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;


class ClientCustomController extends ApiController {

    public function __construct (ClientRepositoryInterface $client){

        $this->client = $client;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getClient(){

        $criteria = array();

        if(Input::get('name')) {
            $criteria['name'] = Input::get('name');
        }

        if(Input::get('school_code')) {
            $criteria['school_code'] = Input::get('school_code');
        }

        if(Input::get('client_role')) {
            $criteria['client_role'] = Input::get('client_role');
        }

        $client_details = $this->client->getClientCustomDetails($criteria);
        $client = array();

        foreach($client_details as  $key => $value){

            $client[$key]['id'] = $value['id'];
            $client[$key]['first_name'] = $value['first_name'];
            $client[$key]['last_name'] = $value['last_name'];
            $client[$key]['email'] = $value['user']['email'];

        }


        return $this->respondWithData( $client);


    }
}
