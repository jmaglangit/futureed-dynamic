<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Services\MailServices as Mail;


use FutureEd\Services\ErrorServices as Errors;

use FutureEd\Http\Requests\Api\ClientTeacherRequest;

use FutureEd\Models\Repository\Client\ClientRepositoryInterface as Client;

use FutureEd\Models\Repository\User\UserRepositoryInterface as User;


use Illuminate\Support\Facades\Input;

class ClientTeacherController extends ApiController {

    protected $client;
    protected $user;

    public function __construct(Client  $client, User $user, Mail $mail){

        $this->client = $client;
        $this->user = $user;
        $this->mail = $mail;

    }



	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $criteria = array();
        $limit = 0;

        if(Input::get('limit')){

            $limit =  Input::get('limit');

        }

        if(Input::get('name')){

            $criteria['name'] = Input::get('name');

        }

        if(Input::get('email')){

            $criteria['email'] = Input::get('email');
        }

        $teacher = $this->client->getTeacherDetails($criteria,$limit);

        return $this->respondWithData($teacher);


	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(ClientTeacherRequest $request){

        $user = $request->only(['email','username']);
        $client = $request->only(['first_name','last_name','current_user']);
        $url = $request->only('callback_uri');

        $client['client_role'] = config('futureed.teacher');
        $user['user_type'] = config('futureed.client');
        $user['name'] = $client['first_name']." ".$client['last_name'];

        $client['street_address'] = null;
        $client['city'] = null;
        $client['state'] = null;
        $client['country'] = null;
        $client['zip'] = null;

        //get current user details
        $current_user_details = $this->client->getClientDetails($client['current_user']);

        //get school_code of current user
        $client['school_code'] = $current_user_details['school_code'];

        //return newly added user details
         $this->user->addUserEloquent($user);

        //get user id
        $user_id = $this->user->checkUserName($user['username'],$user['user_type']);

        //assign user id to client
        $client['user_id'] = $user_id;

        $this->client->addClient($client);

        //send email to invited teacher
        $this->mail->sendMailInviteTeacher($user,$current_user_details,$url);

        $client_id = $this->client->getClientId($user_id);

        return $this->respondWithData(['id' => $client_id
                                     ]);



	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $teacher = $this->client->getClientByUserId($id);

        if(!$teacher){

            return $this->respondErrorMessage(2001);

        }



        return $this->respondWithData($teacher);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
